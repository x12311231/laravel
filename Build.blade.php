@servers(['web' => 'root@192.168.0.19', 'web1' => 'root@192.168.0.18'])

@story('build', ['parallel' => true, 'on' => ['web1']])
    docker-setting-insecure-registry
    update-training-admin-pkg
    update-training-pkg
@endstory

@task('docker-setting-insecure-registry')
    cat <<EOF > /tmp/docker-setting-insecure-registry.sh
    #!/bin/bash

    INSECURE_IP='123.207.51.128:4433'
    INSECURE_REGISTRIES="'insecure-registries': [\"${INSECURE_IP}\"]"

    if [ ! -f /etc/docker/daemon.json ];then
        cat <<EOF > /etc/docker/daemon.json
        {
        ${INSECURE_REGISTRIES}
        }
    EOF
    else
        ip_num=`grep insecure-registries /etc/docker/daemon.json | grep ${INSECURE_IP} | wc -l`
        if [ "${ip_num}" == '0' ];then
            sudo sed -i "1a${INSECURE_REGISTRIES}," /etc/docker/daemon.json
            sudo sed -i "2s/^/\t/" /etc/docker/daemon.json
        fi
    fi
EOF
@endtask

@task('update-training-admin-pkg')
    cat <<EOF > /tmp/update-training-admin-pkg.sh
    #!/bin/bash
    GIT_REMOTE='git@123.207.51.128:/home/git/trainingAdmin.git'
    GIT_TAG='v19.0.0'
    BUILD_DIR='/home/git/trainingAdmin'
    OUTPUT_DIR='/home/git/trainingAdmin/deploy/trainingAdmin/outputs/'
    [ ! -f $BUILD_DIR/.git ] && git init && git remote add origin $GIT_REMOTE
    git pull origin main && \
    git archive $GIT_TAG --format=tar.gz -o ${OUTPUT_DIR}/trainingAdmin.${GIT_TAG}.tar.gz && \
    echo "archive success" && \
    docker-compose build trainingAdmin && \
    docker-compose push trainingAdmin
    EOF
    chmod +x /tmp/update-training-admin-pkg.sh
    sudo /tmp/update-training-admin-pkg.sh
@endtask

@task('update-training-pkg')
    cat <<EOF > /tmp/update-training-pkg.sh
    #!/bin/bash
    GIT_REMOTE='git@123.207.51.128:/home/git/training.git'
    GIT_TAG='v19.0.0'
    BUILD_DIR='/home/git/training'
    OUTPUT_DIR='/home/git/training/deploy/training/outputs/'
    [ ! -f $BUILD_DIR/.git ] && git init && git remote add origin $GIT_REMOTE
    git pull origin main && \
    git archive $GIT_TAG --format=tar.gz -o ${OUTPUT_DIR}/training.${GIT_TAG}.tar.gz && \
    echo "archive success" && \
    docker-compose build training && \
    docker-compose push training
    EOF
    chmod +x /tmp/update-training-pkg.sh
    sudo /tmp/update-training-pkg.sh
@endtask


@task('test')
    cat <<EOF > /tmp/test.sh
    #!/bin/bash
    echo "test"
    EOF
    chmod +x /tmp/test.sh
    sudo /tmp/test.sh
@endtask
