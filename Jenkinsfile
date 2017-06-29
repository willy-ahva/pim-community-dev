#!groovy

stage("Provision") {
    podTemplate(label: "provisioner", containers: [
        containerTemplate(name: "provisioner", image: "lachlanevenson/k8s-kubectl:latest", command: "apply -f .ci/k8s/", ttyEnabled: true)
    ]) {
        node("provisioner") {
            sh "ls"
        }
    }
}

stage("Push") {
    podTemplate(label: "push", containers: [
        containerTemplate(name: "pubsub", image: "eu.gcr.io/akeneo-ci/pubsub", command: "cat", ttyEnabled: true, envVars: [containerEnvVar(key: "DOCKER_API_VERSION", value: "1.23")])
    ], volumes: [
        hostPathVolume(hostPath: "/var/run/docker.sock", mountPath: "/var/run/docker.sock"),
        hostPathVolume(hostPath: "/usr/bin/docker", mountPath: "/usr/bin/docker")
    ]) {
        node("push") {
            container("pubsub") {
                sh "create-topic akeneo-ci-topic"
                sh "push-message akeneo-ci-topic \"docker exec php php -i\""
            }
        }
    }
}
