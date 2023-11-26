@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@192.168.0.18'])

@story('build', ['parallel' => true, 'on' => ['web1']])
docker-setting-insecure-registry
update-training-admin-pkg
update-training-pkg
@endstory

@task('docker-setting-insecure-registry')

@endtask
