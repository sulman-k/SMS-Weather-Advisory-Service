// Any command placed at the root of the file get executed during the 'load' operation
// echo "hello from loading email.groovy"

// Methods declared in external code are accessible directly from other code in the external file
//   indirectly via the object created by the 'load' operation
//   eg.  extcode.hello('use this syntax from your main code')

// Complete workflows should be created inside a controlling method
// else they will run nested inside the named block when the load takes place
//def extMain(whom) {
//    stage 'External Code is running'
//    node() {
//    	echo "Hello ${whom}"
//        hello('from external node block - Although it is deprecated')
 //   }
//}


def init() {
    echo "External groovy script loaded to copy artifacts"
}

def deployArtifacts() {
	
	def date = new Date().format( 'yyyyMMdd' )
    def commit_hash = "${env.GIT_COMMIT}"
    commit_hash = commit_hash.substring(0,10)
	
    sh "mkdir -p /home/jenkins//vas/test/magri/portals/cro/${env.JOB_NAME}/${commit_hash}-${date}"
    sh "cp -r /var/lib/jenkins/workspace/${env.JOB_NAME}/ /home/jenkins/vas/test/magri/portals/cro/${env.JOB_NAME}/${commit_hash}-${date}"
    

} 

// The external code must return it's contents as an object, it's groovy restriction
return this;
