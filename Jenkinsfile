pipeline {
	agent any 
 	stages {

 		/*stage('Cloning Git') {
 			steps {
 				git 'https://github.com/kimkaid/docker-laravel.git'
 			}
 		}*/
 		
		stage('Build') {
	    	steps {
	    	    sh 'export COMPOSE_INTERACTIVE_NO_CLI=1'
	    	    sh 'docker-compose build --force-rm'
	    	    sh 'docker-compose up -d'
	    	    sh 'docker-compose exec -T app composer create-project --prefer-dist laravel/laravel .'
	    	    sh 'docker-compose exec -T app php artisan key:generate'
	    	    sh 'docker-compose exec -T app php artisan storage:link'
	    	    sh 'docker-compose exec -T app chmod -R 777 storage bootstrap/cache'
	    	    sh 'docker-compose exec -T app php artisan migrate'
	    	    sh 'docker-compose exec -T app php artisan db:seed'
	    	    sh 'docker-compose exec -T app php artisan test'
	    	}
	 	}
 	}
 	
 	/*post {
        // Clean after build
        always {
            sh 'cd /var/lib/jenkins/workspace/test/'
            sh 'docker-compose down'
            /*sh 'docker rm -f $(docker ps -a -q)'* /
            sh 'docker volume rm $(docker volume ls -q)'
            /*sh 'docker rmi $(docker images -a)'* /
            cleanWs(cleanWhenNotBuilt: false,
                deleteDirs: true,
                disableDeferredWipeout: true,
                notFailBuild: true,
                patterns: [[pattern: '.gitignore', type: 'INCLUDE'],
                        [pattern: '.propsfile', type: 'EXCLUDE']])
        }
    }*/
 
 	
}
