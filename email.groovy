def init() {
    echo "External groovy script loaded"
}

def sendMailFailure() {
	mail to: 'brad.hunter@sampleweb.com', from: 'devops@sampleweb.com', cc:'john.smith@sampleweb.com,jonas.colt@sampleweb.com',
                subject: "Failed Build: ${env.JOB_NAME}", 
                body: "Job Failed - \"${env.JOB_NAME}\" \n\nView the log at:\n ${env.BUILD_URL}console\n\nURL:\n${env.RUN_DISPLAY_URL}"
} 

def sendMailSuccess() {
	mail to: 'brad.hunter@sampleweb.com', from: 'devops@sampleweb.com', cc:'john.smith@sampleweb.com,jonas.colt@sampleweb.com,shah.colt@sampleweb.com',
                subject: "Success Build: ${env.JOB_NAME}",
                body: "New Build has been generated - \"${env.JOB_NAME}\" \n\nView the log at:\n ${env.BUILD_URL}console\n\nURL:\n${env.RUN_DISPLAY_URL}"
	
}  
  
// The external code must return it's contents as an object, it's groovy restriction
return this;

