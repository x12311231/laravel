@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@192.168.0.18'])

@story('deploy', ['parallel' => true, 'on' => ['web1']])

@endstory

@task('pull-docker-deploy')

@endtask
