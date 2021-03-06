<?php

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;
namespace App\Enjoythetrip\Gateways; /* Lecture 27 */

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface; /* Lecture 27 */ 


/* Lecture 27 */
class BackendGateway { 
    

    public function __construct(BackendRepositoryInterface $bR ) 
    {
        $this->bR = $bR;
    }
    
    
    
    public function getReservations($request)
    {
        if ($request->user()->hasRole(['owner','admin']))
        {

            $objects = $this->bR->getOwnerReservations($request);

        }
        else
        {
            
            $objects = $this->bR->getTouristReservations($request);
        }
        
        return $objects;
    }
    

}


