
pipeline {
    //  Don’t run on a node at all - manage node blocks ourself within our stages.
    agent any

    parameters {
        string(name: 'PERSON', defaultValue: 'Mr Jenkins', description: 'Who should I say hello to?')
        //booleanParam(defaultValue: true, description: 'Run unit tests and code style checks', name: 'launchUnitTests')
        //booleanParam(defaultValue: true, description: 'Run integration tests', name: 'launchIntegrationTests')
        //booleanParam(defaultValue: true, description: 'Run behat tests', name: 'launchBehatTests')
        //string(defaultValue: 'odm,orm', description: 'Storage used for the behat tests (comma separated values)', name: 'storages')
        //string(defaultValue: 'ee,ce', description: 'PIM edition the behat tests should run on (comma separated values)', name: 'editions')
        //string(defaultValue: 'features,vendor/akeneo/pim-community-dev/features', description: 'Behat scenarios to build', name: 'features')
        //booleanParam(defaultValue: false, description: 'ElasticSearch version to run behat with', name: 'esVersion')

        // booleanParam(defaultValue: true, description: 'PHP version to run behat with', name: 'phpVersion')
        // booleanParam(defaultValue: true, description: 'Mysql version to run behat with', name: 'mysqlVersion')
    }

    stages {
        stage("Checkout") {

            steps {
                echo "Hello ${params.PERSON}"
                sh "pwd"
            }

            //steps {
            //    script {
            //        userInput = input message: 'Launch tests?',
            //            parameters: [
            //                choice(choices: 'yes\nno', description: 'Run unit tests and code style checks', name: 'launchUnitTests'),
            //                choice(choices: 'yes\nno', description: 'Run integration tests', name: 'launchIntegrationTests'),
            //                choice(choices: 'yes\nno', description: 'Run behat tests', name: 'launchBehatTests'),
            //                string(defaultValue: 'odm,orm', description: 'Storage used for the behat tests (comma separated values)', name: 'storages'),
            //                string(defaultValue: 'ee,ce', description: 'PIM edition the behat tests should run on (comma separated values)', name: 'editions'),
            //                string(defaultValue: 'features,vendor/akeneo/pim-community-dev/features', description: 'Behat scenarios to build', name: 'features'),
            //                choice(choices: '5.6\n7.0\n7.1', description: 'PHP version to run behat with', name: 'phpVersion'),
            //                choice(choices: '5.5\n5.7', description: 'Mysql version to run behat with', name: 'mysqlVersion'),
            //                choice(choices: 'none\n1.7\n5', description: 'ElasticSearch version to run behat with', name: 'esVersion')
            //            ]
            //    }
            //    echo "${userInput}"
            //}


            //steps {
            //    userInput = input(message: 'Launch tests?', parameters: [
            //        choice(choices: 'yes\nno', description: 'Run unit tests and code style checks', name: 'launchUnitTests'),
            //        choice(choices: 'yes\nno', description: 'Run integration tests', name: 'launchIntegrationTests'),
            //        choice(choices: 'yes\nno', description: 'Run behat tests', name: 'launchBehatTests'),
            //        string(defaultValue: 'odm,orm', description: 'Storage used for the behat tests (comma separated values)', name: 'storages'),
            //        string(defaultValue: 'ee,ce', description: 'PIM edition the behat tests should run on (comma separated values)', name: 'editions'),
            //        string(defaultValue: 'features,vendor/akeneo/pim-community-dev/features', description: 'Behat scenarios to build', name: 'features'),
            //        choice(choices: '5.6\n7.0\n7.1', description: 'PHP version to run behat with', name: 'phpVersion'),
            //        choice(choices: '5.5\n5.7', description: 'Mysql version to run behat with', name: 'mysqlVersion'),
            //        choice(choices: 'none\n1.7\n5', description: 'ElasticSearch version to run behat with', name: 'esVersion')
            //    ])
            //}

            //steps {
            //    echo ${storages}
            //    echo ${editions}
            //    echo ${features}
            //    echo ${phpVersion}
            //    echo ${mysqlVersion}
            //    echo ${esVersion}
            //    echo ${launchUnitTests}
            //    echo ${launchIntegrationTests}
            //    echo ${launchBehatTests}
            //}

            // script {
            //     if (env.BRANCH_NAME =~ /^PR-/) {
            //         userInput = input(message: 'Launch tests?', parameters: [
            //             choice(choices: 'yes\nno', description: 'Run unit tests and code style checks', name: 'launchUnitTests'),
            //             choice(choices: 'yes\nno', description: 'Run integration tests', name: 'launchIntegrationTests'),
            //             choice(choices: 'yes\nno', description: 'Run behat tests', name: 'launchBehatTests'),
            //             string(defaultValue: 'odm,orm', description: 'Storage used for the behat tests (comma separated values)', name: 'storages'),
            //             string(defaultValue: 'ee,ce', description: 'PIM edition the behat tests should run on (comma separated values)', name: 'editions'),
            //             string(defaultValue: 'features,vendor/akeneo/pim-community-dev/features', description: 'Behat scenarios to build', name: 'features'),
            //             choice(choices: '5.6\n7.0\n7.1', description: 'PHP version to run behat with', name: 'phpVersion'),
            //             choice(choices: '5.5\n5.7', description: 'Mysql version to run behat with', name: 'mysqlVersion'),
            //             choice(choices: 'none\n1.7\n5', description: 'ElasticSearch version to run behat with', name: 'esVersion')
            //         ])
//
            //         storages = userInput['storages'].tokenize(',')
            //         editions = userInput['editions'].tokenize(',')
            //         features = userInput['features']
            //         phpVersion = userInput['phpVersion']
            //         mysqlVersion = userInput['mysqlVersion']
            //         esVersion = userInput['esVersion']
            //         launchUnitTests = userInput['launchUnitTests']
            //         launchIntegrationTests = userInput['launchIntegrationTests']
            //         launchBehatTests = userInput['launchBehatTests']
            //     }
            //}

            //steps {
            //    echo ${storages}
            //    echo ${editions}
            //    echo ${features}
            //    echo ${phpVersion}
            //    echo ${mysqlVersion}
            //    echo ${esVersion}
            //    echo ${launchUnitTests}
            //    echo ${launchIntegrationTests}
            //    echo ${launchBehatTests}
            //}
        }
    }
}