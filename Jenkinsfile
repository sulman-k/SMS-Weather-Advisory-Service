def extcode
pipeline {
    agent any
    stages {
      stage('LoadExtCode') {
            steps {
            	script {
        			extcode = load 'email.groovy'
        			extcode.init()
            	}
            }
        }
        stage('Deploy') {
	         steps{
                    script {
                        def copyArt
                        copyArt = load 'artifacts.groovy'
        		        copyArt.deployArtifacts()
        	        }
            }
	
        }
            
    }
       post {
            failure {
            	script {
            		extcode.sendMailFailure()
            	}
            	
            }
    	    success {
    	    	script {
    	    		extcode.sendMailSuccess()
    	    	}
    	    	
    	    }
	    
	    }
    

}
