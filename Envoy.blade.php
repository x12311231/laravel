@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@117.72.10.250', 'web2' => 'root@45.32.33.65', 'web3' => 'docker1@192.168.0.19', 'web4' => 'root@202.182.116.24'])

@task('deploy')
    cd /tmp
    mkdir laravel
    cd laravel
    echo hello > hello
@endtask

@story('setup', ['parallel' => true, 'on' => ['web4']])
    timezone
    setup-tools
    remove-docker
    setup-docker
    docker-registry
    setup-dnmp
    setup-mycms
@endstory

@story('reinstall-docker', ['parallel' => true, 'on' => ['web4']])
    remove-docker
    setup-docker
@endstory

@task('server-update')
    sudo yum install -y epel-release
@endtask

@task('setup-tools')
    sudo yum install -y vim htop git
@endtask

@task('timezone')
    timedatectl set-timezone Asia/Shanghai
@endtask

@task('remove-docker')
    sudo yum remove -y docker \
    docker-client \
    docker-client-latest \
    docker-common \
    docker-latest \
    docker-latest-logrotate \
    docker-logrotate \
    docker-engine \
    docker-compose
@endtask

@task('setup-docker')
    sudo yum install -y yum-utils \
    device-mapper-persistent-data \
    lvm2
    sudo yum-config-manager \
    --add-repo \
    https://download.docker.com/linux/centos/docker-ce.repo
    sudo yum install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
    ln -s /usr/libexec/docker/cli-plugins/docker-compose /usr/local/bin/docker-compose
    sudo systemctl start docker
    sudo systemctl enable docker
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

@task('docker-registry')
    sudo mkdir -p /etc/docker
    sudo tee /etc/docker/daemon.json <<-'EOF'
    {
      "registry-mirrors": ["https://registry.docker-cn.com"]
    }
    EOF
    sudo systemctl daemon-reload
    sudo systemctl restart docker
@endtask

@task('setup-dnmp')
    mkdir -p /website/
    cd /website/
    git clone https://gitee.com/xhq192/dnmp.git
    cd dnmp
    git fetch origin php73_80-mysql57-redis5-nginx
    git checkout php73_80-mysql57-redis5-nginx
    cp env.demo .env
    sed -i 's/MYSQL5_ROOT_PASSWORD=123456/MYSQL5_ROOT_PASSWORD=docker123456/g' .env
    sudo service docker start
    docker-compose up -d
@endtask

@task('setup-mycms')
    cd /website/dnmp
    cd www
    git clone https://gitee.com/qq386654667/mycms.git
    chmod -R 777 ../www/mycms/storage
    chmod -R 777 ../www/mycms/bootstrap/cache
    cd ../www/mycms
    cd ../services/nginx/conf.d
    cp laravel.conf.demo mycms.conf
    sed -i 's/laravel/mycms/g' mycms.conf
@endtask
