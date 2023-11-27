@servers(['web1' => 'root@123.207.51.128'])

@story('build', ['parallel' => true, 'on' => ['web1']])
    update-training-admin-pkg
    update-training-pkg
@endstory

@task('docker-setting-insecure-registry')
    cat <<EOF > /tmp/docker-setting-insecure-registry.sh
    #!/bin/bash

    INSECURE_IP='123.207.51.128:4433'
    INSECURE_REGISTRIES="'insecure-registries': [\"${INSECURE_IP}\"]"

    if [ ! -f /etc/docker/daemon.json ];then
        cat <<EOFF > /etc/docker/daemon.json
        {
        ${INSECURE_REGISTRIES}
        }
    EOFF
    else
        ip_num=`grep insecure-registries /etc/docker/daemon.json | grep ${INSECURE_IP} | wc -l`
        if [ "${ip_num}" == '0' ];then
            sudo sed -i "1a${INSECURE_REGISTRIES}," /etc/docker/daemon.json
            sudo sed -i "2s/^/\t/" /etc/docker/daemon.json
        fi
    fi
EOF
    sudo systemctl restart docker
@endtask

@task('update-training-admin-pkg')
    @if (!$git_tag)
        echo "please input git tag"
        exit 1
    @endif
    cat <<EOF > /tmp/update-training-admin-pkg.sh
    #!/bin/bash
    GIT_REMOTE='git@123.207.51.128:/home/git/trainingAdmin.git'
    GIT_TAG={{ $git_tag }}
    BUILD_DIR='/build/trainingAdmin'
    OUTPUT_DIR='/build/trainingAdmin/deploy/trainingAdmin/outputs'
    docker login 123.207.51.128:4433

    mkdir -p \${BUILD_DIR} && \
    mkdir -p \${OUTPUT_DIR} && \
    cd \${BUILD_DIR} && \
    [ ! -f \${BUILD_DIR}/.git ] && git init && git remote add origin \${GIT_REMOTE}
    git pull origin main --tags && \
    sed -i 's/PKG_VERSION/{{ $git_tag }}/g' \${OUTPUT_DIR}/../Dockerfile && \
    sed -i 's/DOCKER_TAG/{{ $git_tag }}/g' \${BUILD_DIR}/docker-compose.yml && \
    git archive {{ $git_tag }} --format=tar.gz -o \${OUTPUT_DIR}/trainingAdmin.{{ $git_tag }}.tar.gz && \
    echo "archive success" && \
    /usr/local/bin/docker-compose build trainingAdmin && \
    /usr/local/bin/docker-compose push trainingAdmin
    EOF
    chmod +x /tmp/update-training-admin-pkg.sh
    sudo /tmp/update-training-admin-pkg.sh
@endtask

@task('update-training-pkg')
    @if (!$git_tag)
        echo "please input git tag"
        exit 1
    @endif
    cat <<EOF > /tmp/update-training-pkg.sh
    #!/bin/bash
    GIT_REMOTE='git@123.207.51.128:/home/git/training.git'
    GIT_TAG={{ $git_tag }}
    BUILD_DIR='/build/training'
    OUTPUT_DIR='/build/training/deploy/training/outputs'
    docker login 123.207.51.128:4433

    mkdir -p \$BUILD_DIR && \
    mkdir -p \$OUTPUT_DIR  && \
    cd \$BUILD_DIR && \
    [ ! -f \$BUILD_DIR/.git ] && git init && git remote add origin \$GIT_REMOTE
    git pull origin main --tags && \
    sed -i 's/PKG_VERSION/{{ $git_tag }}/g' \${OUTPUT_DIR}/../Dockerfile && \
    sed -i 's/DOCKER_TAG/{{ $git_tag }}/g' \${BUILD_DIR}/docker-compose.yml && \
    git archive \$GIT_TAG --format=tar.gz -o \${OUTPUT_DIR}/training.\${GIT_TAG}.tar.gz && \
    echo "archive success" && \
    /usr/local/bin/docker-compose build training && \
    /usr/local/bin/docker-compose push training
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
