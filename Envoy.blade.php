@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@192.168.0.18'])

@task('deploy')
    cd /tmp
    mkdir laravel
    cd laravel
    echo hello > hello
@endtask

@story('setup', ['parallel' => true])
    timezone
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

@task('timezone')
    timedatectl set-timezone Asia/Shanghai
@endtask
@task('setup-docker')
    sudo yum install -y yum-utils \
    device-mapper-persistent-data \
    lvm2
    sudo yum-config-manager \
    --add-repo \
    https://mirrors.tuna.tsinghua.edu.cn/docker-ce/linux/centos/docker-ce.repo
    sudo yum install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
    [ ! -f /usr/local/bin/docker-compose ] && ln -s /usr/libexec/docker/cli-plugins/docker-compose /usr/local/bin/docker-compose
@endtask

@task('confirm', ['confirm' => true])
    echo `date` >> /tmp/confirm.log
@endtask

@task('onweb', ['on' => 'web', 'confirm' => true])
    echo web confirm `date` >> /tmp/confirm.log
@endtask

@task('onweb1', ['on' => 'web1', 'confirm' => true])
    echo web1 confirm `date` >> /tmp/confirm.log
@endtask

