#!groovy

stage("Build") {
    podTemplate(label: "build", containers: [
        containerTemplate(name: "docker", image: "docker:stable", command: "cat", ttyEnabled: true, envVars: [containerEnvVar(key: "DOCKER_API_VERSION", value: "1.23")])
    ], volumes: [
        hostPathVolume(hostPath: "/var/run/docker.sock", mountPath: "/var/run/docker.sock"),
        hostPathVolume(hostPath: "/usr/bin/docker", mountPath: "/usr/bin/docker")
    ]) {
        node("build") {
            container("docker") {
                checkout scm
                sh "docker build -t eu.gcr.io/akeneo-ci/pim-community-dev:pull-request-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ce ."
                sh "docker push eu.gcr.io/akeneo-ci/pim-community-dev:pull-request-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ce"

                deleteDir()

                checkout([$class: "GitSCM",
                    branches: [[name: "kubernetes-experimentation"]],
                    userRemoteConfigs: [[credentialsId: "github-credentials", url: "https://github.com/ClementGautier/pim-enterprise-dev.git"]]
                ])
                sh "docker build -t eu.gcr.io/akeneo-ci/pim-community-dev:pull-request-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ee ."
                sh "docker push eu.gcr.io/akeneo-ci/pim-community-dev:pull-request-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ee"
            }
        }
    }
}

stage("Tests") {
    parallel(
        "php-coupling-detector": {runPhpCouplingDetectorTest()}
    )
}

def runPhpCouplingDetectorTest() {
    podTemplate(label: "test", containers: [
        containerTemplate(name: "pim", image: "eu.gcr.io/akeneo-ci/pim-community-dev:pull-request-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ce", command: "cat", ttyEnabled: true),
        containerTemplate(name: "pubsub", image: "eu.gcr.io/akeneo-ci/pubsub", command: "cat", ttyEnabled: true, envVars: [containerEnvVar(key: "PUBSUB_PROJECT_ID", value: "akeneo-ci")])
    ]) {
        node("test") {
            container("pubsub") {
                sh "php /app/create-topic pim-community-dev-pr-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ce"
                sh "php /app/publish pim-community-dev-pr-${env.CHANGE_ID}-build-${env.BUILD_NUMBER}-ce test"
            }
        }
    }
}
