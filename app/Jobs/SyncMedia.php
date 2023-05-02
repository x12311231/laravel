<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SyncMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $post;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Post $post,
        public readonly string $name,
        public readonly string $content,
    )
    {
//        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $path = 'images/' . $this->name;
        // 如果文件已存在，则退出
        if (Storage::disk('public')->exists($path)) {
            return;
        }
        // 文件存储成功，则将其保存到数据库，否则 5s 后重试
        if (Storage::disk('public')->put($path, base64_decode($this->content))) {
            $image = new Image();
            $image->name = $this->name;
            $image->path = $path;
            $image->url = config('app.url') . '/storage/' . $path;
            $image->author_id = $this->post->author_id;
            if ($image->save()) {
                // 图片保存成功，则更新 posts 表的 image_id 字段
                $this->post->image_id = $image->id;
                $image->posts()->save($this->post);
            } else {
                // 图片保存失败，则删除当前图片，并在 5s 后重试此任务
                Storage::disk('public')->delete($path);
                $this->release(5);
            }

            // 如果有缩略图、裁剪等后续处理，可以在这里执行
        } else {
            $this->release(5);
        }
    }
}
