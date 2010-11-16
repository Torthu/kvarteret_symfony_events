<?php

/**
 * event
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kvarteret_events
 * @subpackage model
 * @author     Endre Oma
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class event extends Baseevent
{

  /**
   * Returns recurring location if location_id is set, 
   * if not it will return custom location
   */
  public function getLocation ()
  {
    if (!$this->location_id) {
      return $this->customLocation;
    } else {
      return $this->getRecurringLocation();
    }
  }

  /**
   * setDescription will escape and remove illegal tags and script in description.
   * We'll only allow certain tags, and certain attributes on tags
   */
  public function setDescription ($value) {
    $purifier = new myHTMLPurifier();

    // purifier configuration:
    // documentation: http://stackoverflow.com/questions/1320524/how-to-allow-certain-html-tags-in-a-form-field-in-symfony-1-2/1321794#1321794
    $purifier_config = $purifier->createConfig();

    $purifier_config->set('HTML.DefinitionID', 'eventDescription');
    $purifier_config->set('HTML.DefinitionRev', 1);

    // clean empty tags
    $purifier_config->set('AutoFormat.RemoveEmpty', true);
    //$purifier_config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
    //$purifier_config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

    // these are allowed html tags, means white list
    $purifier_config->set('HTML.AllowedElements', 'a,strong,em,p,span,img,li,ul,ol,blockquote');

    // these are allowed html attributes, coool!
    $purifier_config->set('HTML.AllowedAttributes', 'a.href,a.title,span.style,span.class,span.id,p.style,img.src,img.style,img.alt,img.title,img.width,img.height');

    // now clean your data
    $clean_html = $purifier->purify($value, $purifier_config);

    $this->_set('description', $clean_html);
  }

  public function setLeadParagraph ($value) {
    $purifier = new myHTMLPurifier();

    // purifier configuration:
    // documentation: http://stackoverflow.com/questions/1320524/how-to-allow-certain-html-tags-in-a-form-field-in-symfony-1-2/1321794#1321794
    $purifier_config = $purifier->createConfig();

    $purifier_config->set('HTML.DefinitionID', 'eventLeadParagraph');
    $purifier_config->set('HTML.DefinitionRev', 1);

    // clean empty tags
    $purifier_config->set('AutoFormat.RemoveEmpty', true);
    $purifier_config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
    //$purifier_config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

    // these are allowed html tags, means white list
    $purifier_config->set('HTML.AllowedElements', 'p');

    // these are allowed html attributes, coool!
    //$purifier_config->set('HTML.AllowedAttributes', '');

    // now clean your data
    $clean_html = $purifier->purify($value, $purifier_config);

    $this->_set('leadParagraph', $clean_html);
  }
}
