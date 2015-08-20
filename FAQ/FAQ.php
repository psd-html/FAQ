<?php
class FAQ extends plxPlugin {

		public function __construct($default_lang) {

			parent::__construct($default_lang);

			# Pour accéder à une page d'administration
    		$this->setAdminProfil(PROFIL_ADMIN);

			$this->setConfigProfil(PROFIL_ADMIN);

			$this->addHook('AdminTopEndHead', 'AdminTopEndHead');

			$this->addHook('ThemeEndHead', 'ThemeEndHead');
			$this->addHook('ThemeEndBody', 'ThemeEndBody');

			$this->addHook('FAQ', 'FAQ');
		}

		public function ThemeEndHead() { ?>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>
			<?php
		}		

		public function AdminTopEndHead() { ?>
			<link rel="stylesheet" href="<?php echo PLX_PLUGINS ?>FAQ/app/style.min.css" media="screen"/>
			<?php
		}
	

		public function FAQ() {?>			

		<div ng-app="myApp" ng-controller="MainCtrl">

	
		<input type="text" ng-model="searchFriend" placeholder="Chercher dans la liste">



		<div class="friend" ng-repeat="friend in friendlist | filter:searchFriend" style="margin-top:20px">
				<h3>{{friend.question}}</h3>
				<p ng-bind-html="friend.reponse| unsafe"></p>
		</div>		


		</div>


		<script>
		    var app = angular.module('myApp', []);

		    app.controller('MainCtrl', function($scope) {
		        $scope.friendlist = [ 

		<?php

			$nb_questions = floor(sizeof($this->aParams)/2); // nombre de commentaire

				$nb_questions = $nb_questions + 1;
			
				for($i=1; $i<$nb_questions; $i++) { // boucle pour afficher les commentaires

					$question = $this->getParam('question'.$i);
					$reponse = $this->getParam('reponse'.$i);

					//On traite les valeurs de Question (a) et de réponse (b)
					$a = html_entity_decode($question, ENT_QUOTES, 'UTF-8');

					//nettoyage de la chaîne 
					$b = preg_replace("/\s+/", " ", $reponse);
					$b = html_entity_decode($b, ENT_QUOTES, 'UTF-8');

					if(!empty($question)) { ?>
						{"question": "<?php echo $a;?>",  "reponse": "<?php echo $b;?>"},
					<?php
					}// endif			
				}// endfor	?>

			        ];
			    });

			    // Préserver le code HTML dans la sortie du texte 
				app.filter('unsafe', function($sce) {
				    return function(val) {
				        return $sce.trustAsHtml(val);
				    };
				});

		</script>

		<?php
		}	
	
	} // class Faqs
?>
