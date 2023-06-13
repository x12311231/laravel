@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@192.168.0.18'])

@task('deploy')
    cd /tmp
    mkdir laravel
    cd laravel
    echo hello > hello
@endtask

@story('setup')
    server-update
    setup-tools
    setup-docker
@endstory

@task('server-update')
    sudo yum install -y epel-release
@endtask

@task('setup-tools')
    sudo yum install -y vim
@endtask

@task('setup-docker')
    sudo yum install -y yum-utils \
    device-mapper-persistent-data \
    lvm2
    sudo yum-config-manager \
    --add-repo \
    https://mirrors.tuna.tsinghua.edu.cn/docker-ce/linux/centos/docker-ce.repo
    sudo yum install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
    ln -s /usr/libexec/docker/cli-plugins/docker-compose /usr/local/bin/docker-compose
@endtask
