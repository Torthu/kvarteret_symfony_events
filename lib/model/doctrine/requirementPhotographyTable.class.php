<?php

/**
 * requirementPhotographyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class requirementPhotographyTable extends locationReservationRequirementBaseTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object requirementPhotographyTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('requirementPhotography');
    }
}