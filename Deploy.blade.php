@servers(['web1' => 'root@192.168.0.18'])

@story('deploy', ['parallel' => true, 'on' => ['web1']])
    @if (!$restart)
        pull-docker-deploy
    @else
        restart
    @endif
@endstory

@task('restart')
    cd /deploy/
    /usr/local/bin/docker-compose restart
@endtask


@task('pull-docker-deploy')
    @if (!$git_tag)
        echo "please input git tag"
        exit 1
    @endif
    cat <<EOF > /tmp/deploy.sh
    #!/bin/bash
    docker login 123.207.51.128:4433 && \
    docker pull 123.207.51.128:4433/train/deploy-docker:latest && \
    deploy_stat=`docker ps -qa -f name=deploy | wc -l`
    [ '1' == "deploy_stat" ] && docker rm -f deploy
    docker run --name deploy -d 123.207.51.128:4433/train/deploy-docker:latest
    rm -rf /deploy/*
    mkdir -p /deploy/
    docker cp deploy:/outputs/deploy.tar.gz /deploy/
    tar -zxvf /deploy/deploy.tar.gz -C /deploy/
    rm -rf /deploy/deploy.tar.gz
    cd /deploy/
    sed -i "s/DOCKER_TAG/{{ $git_tag }}/g" docker-compose.yml
    sel -i "s/DOCKER_TAG/{{ $git_tag }}/g" app/Dockerfile
    sel -i "s/DOCKER_TAG/{{ $git_tag }}/g" admin/Dockerfile
    docker stop deploy
    docker rm -f deploy

    docker pull 123.207.51.128:4433/train/config:latest
    config_stat=`docker ps -qa -f name=config | wc -l`
    [ '1' == "$config_stat" ] && docker rm -f config345345324
    docker run --name config345345324 -d 123.207.51.128:4433/train/config:latest
    docker cp config345345324:/data/config.ini.pro /deploy/app/config.ini
    docker cp config345345324:/data/config.ini.pro /deploy/admin/config.ini
    docker stop config345345324
    docker rm -f config345345324

    docker pull 123.207.51.128:4433/train/training_admin:{{ $git_tag }}
    docker pull 123.207.51.128:4433/train/training:{{ $git_tag }}
    /usr/local/bin/docker-compose build
    /usr/local/bin/docker-compose up -d
    EOF
    chmod +x /tmp/deploy.sh
    sudo /tmp/deploy.sh
@endtask
