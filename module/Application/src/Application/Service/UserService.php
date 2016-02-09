<?php
/**
 * Service
 * @package Application\Service
 * @author Bidoum
 *
 */
namespace Application\Service;
 
/**
 * Service
 * 
 * @package Application\Service
 * @author auget
 *
 */
class UserService extends \Application\Service\AbstractService
{
    /**
     * Obtient un utilisateur par son email
     * @param string email
     * @return Application\Entity\User
     */
    public function getByEmail($email)
    {
        $qb = $this->getEm()->createQueryBuilder();
     
        $qb->select(array('u'))
            ->from('Application\Entity\User', 'u')
            ->where(
                $qb->expr()->eq('u._email', '?1')
            )
            ->setParameters(array(1 => $email))
        ;
     
        $query = $qb->getQuery();
     
        return $query->getSingleResult();
    }

    public function checkUnique($username)
    {
        $select = $this->_db->select()
                    ->from($this->_username,array('username'))
                    ->where('username=?',$username);
        $result = $this->getAdapter()->fetchOne($select);
        if($result){
            return true;
        }
        return false;
    }
}