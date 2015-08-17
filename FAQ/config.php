<?php 
if(!defined('PLX_ROOT')) exit;
# Control du token du formulaire
plxToken::validateFormToken($_POST);
# nombre de reponses existants
$nbreponse = floor(sizeof($plxPlugin->getParams())/2);
if(!empty($_POST)) {

	if (!empty($_POST['question-new']) AND !empty($_POST['reponse-new']))  {
        # création d'un nouveau reponse
        $newreponse = $nbreponse + 1;
		$plxPlugin->setParam('question'.$newreponse, plxUtils::strCheck($_POST['question-new']), 'cdata');
		$plxPlugin->setParam('reponse'.$newreponse, plxUtils::strCheck($_POST['reponse-new']), 'cdata');
        $plxPlugin->saveParams();
        
	}else{
        
        # Mise à jour des reponses existants
        for($i=1; $i<=$nbreponse; $i++) {
            if($_POST['delete'.$i] != "1" AND !empty($_POST['question'.$i]) AND !empty($_POST['reponse'.$i])){ // si on ne supprime pas et que les reponses ne sont pas vide
                
                #mise a jour du question et reponse
                $plxPlugin->setParam('question'.$i, plxUtils::strCheck($_POST['question'.$i]), 'cdata');
                $plxPlugin->setParam('reponse'.$i, plxUtils::strCheck($_POST['reponse'.$i]), 'cdata');
                $plxPlugin->saveParams();
            
            }elseif($_POST['delete'.$i] == "1"){
                $plxPlugin->setParam('question'.$i, '', '');
                $plxPlugin->setParam('reponse'.$i, '', '');
                $plxPlugin->saveParams();
            }
        }
    }
}
# mise à jour du nombre de reponses existants
	$nbreponse = floor(sizeof($plxPlugin->getParams())/2);
?>

<!-- navigation sur la page configuration du plugin -->
<nav id="tabby-1" class="tabby-tabs" data-for="example-tab-content">
	<ul>
		<li><a data-target="tab1" class="active" href="#"><?php $plxPlugin->lang('L_NAV_LIEN1') ?></a></li>
		<li><a data-target="tab2" href="#"><?php $plxPlugin->lang('L_NAV_LIEN2') ?></a></li>
		<li><a data-target="tab3" href="#"><?php $plxPlugin->lang('L_NAV_LIEN3') ?></a></li>
	</ul>
</nav>

<!-- contenu de la page configuration -->
<div class="tabby-content" id="example-tab-content">


<!-- page pour afficher les témoignages -->
<div data-tab="tab1">

    <h2><?php $plxPlugin->lang('L_NAV_LIEN1') ?></h2>

    <div class="formulaire">
        <!-- reponses déja créés -->
        <form action="parametres_plugin.php?p=FAQ" method="post">
            <fieldset>
                <table class="full-width">
                    <thead>
                        <tr>
                            <th class="id"><?php $plxPlugin->lang('L_TAB_1') ?></th>
                            <th><?php $plxPlugin->lang('L_TAB_2') ?></th>
                            <th><?php $plxPlugin->lang('L_TAB_3') ?></th>
                            <th class="checkbox"><?php $plxPlugin->lang('L_TAB_4') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php for($i=1; $i<=$nbreponse; $i++) {?>
                        <?php $question = $plxPlugin->getParam(question.$i);
                        if(!empty($question)) { ?>
                        
                        <tr class="line-<?php echo $i%2 ?>">
                            <td>
                                <?php echo $i; ?>
                            </td>
                            
                            <td class="question">
                                <textarea rows="2"  name="question<?php echo $i; ?>"><? echo $plxPlugin->getParam(question.$i); ?></textarea>
                            </td>
                            
                            <td class="reponse">
                                <textarea rows="2"   name="reponse<?php echo $i; ?>"><? echo $plxPlugin->getParam(reponse.$i); ?></textarea>
                            </td>
                            
                            <td class="checkbox">
                                <input type="checkbox" name="delete<?php echo $i; ?>" value="1">
                            </td>
                        </tr>
                            <?php }; ?>
                                <?php }; ?>
                    </tbody>

                </table>
            </fieldset>

                    <p class="in-action-bar">
                        <?php echo plxToken::getTokenPostMethod() ?>
                        <input class="bt" type="submit" name="submit" value="<?php $plxPlugin->lang('L_FORM_BT1') ?>" />
                    </p>
        </form>
    </div>

</div><!-- de la premiere page -->

<!-- page pour créer un témoignage -->
<div data-tab="tab2">

<h2><?php $plxPlugin->lang('L_NAV_LIEN2') ?></h2>

<div class="new">

    <form action="parametres_plugin.php?p=FAQ" method="post">
        <p>
            <label for="question"><?php $plxPlugin->lang('L_FORM_1') ?></label>
             <input type="text" name="question-new" value="" />
        </p>
        
        <p>
            <label for="reponse"><?php $plxPlugin->lang('L_FORM_2') ?></label>
            <textarea rows="8"   name="reponse-new" value=""></textarea>
        </p> 

        <p>
            Vous pouvez ajouter les mises en forme du texte HTML <br>
            <code>
                    &lt;a href='votre lien' title='votre titre'&gt;Votre lien&lt;/a&gt;
            </code>
            <br>
            <code>
                    &lt;br&gt;, &lt;p&gt; &lt;/p&gt; ...
            </code>
        </p>  

        <p>Pensez à mettre des simples quote.</p>                                                              
                       
        <p class="in-action-bar">
            <?php echo plxToken::getTokenPostMethod() ?>
            <input class="bt" type="submit" name="submit" value="<?php $plxPlugin->lang('L_FORM_BT2') ?>" />
        </p>

    </form>
</div>

</div><!-- fin de la page 3 -->

<!-- page de configuration -->
<div data-tab="tab3">
    <h2><?php $plxPlugin->lang('L_NAV_LIEN3') ?></h2>

    <p>Pour afficher le plugin Faqs dans une page statique :</p>

    <p>
            <code>
                    &lt;?php global $plxShow;
                    eval($plxShow->callHook("FAQ")); ?&gt;
            </code>

    </p>

    <p>Si vous avez des questions, merci de me contacter sur mon site: <a href="http://libertea.fr" title="libertea">http://libertea.fr</a></p>



    
</div>


</div>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="<?php echo PLX_PLUGINS ?>FAQ/app/jquery.tabby.js"></script>
<script>
    $(document).ready(function(){
        $('#tabby-1').tabby();
    });
</script>