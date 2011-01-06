<?php

require_once dirname(__FILE__).'/../lib/eventGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eventGeneratorHelper.class.php';

/**
 * event actions.
 *
 * @package    kvarteret_events
 * @subpackage event
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventActions extends autoEventActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function getCredential()
  {
    $action = $this->getActionName();
    $user = $this->getUser();

    if (!$user->hasCredential('admin') && in_array($action, array('edit', 'delete', 'update', 'batchDelete')))
    {
      $this->event = $this->getRoute()->getObject();
      $usersArrangers = Doctrine_Core::getTable('arrangerUser')->getUsersArrangers($user->getGuardUser()->getId());

      if (in_array($this->event->getArrangerId(), $usersArrangers)) {
        $this->getUser()->addCredential('owner');
      } else {
        $this->getUser()->removeCredential('owner');
      }
    }
 
    // the hijack is over, let the normal flow continue:
    return parent::getCredential();
  }

  public function executeShow(sfWebRequest $request) {
    $this->event = $this->getRoute()->getObject();
  }

  public function executeNew(sfWebRequest $request)
  {

    $options = $this->configuration->getFormOptions();

    if ($request->hasParameter('festival_id'))
    {
      $options['festival_id'] = $request->getParameter('festival_id');
    }

    $this->form = $this->configuration->getForm(null, $options);
    $this->event = $this->form->getObject();
  }

  protected function buildQuery()
  {
    $query = parent::buildQuery();
    // do what ever you like with the query like

    if ( $this->getUser()->isAuthenticated() && ! $this->getUser()->hasGroup('admin') ) {
      $arrangerUsers = $this->getUser()->getArrangerIds();

      if ( count($arrangerUsers) > 0 ) {
        $query->andWhereIn('arranger_id', $arrangerUsers);
      } else {
        // No events can be created with arranger_id set to null
        $query->andWhere('arranger_id is null');
      }
    }
    return $query;
  }


}
