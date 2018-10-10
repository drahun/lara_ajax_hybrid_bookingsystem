<?php 
namespace App\Enjoythetrip\Gateways; /* Lecture 17 */

use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface; /* Lecture 17 */ 

/* Lecture 17 */
class FrontendGateway { 
    
     
    /* Lecture 17 */
    public function __construct(FrontendRepositoryInterface $fR ) 
    {
        $this->fR = $fR;
    }
    
    
    /* Lecture 17 */
    public function searchCities($request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = $this->fR->getSearchCities($term);

        foreach ($queries as $query)
        {
            $results[] = ['id' => $query->id, 'value' => $query->name];
        }

        return $results;
    } 
    
    
    /* Lecture 18 */
    public function getSearchResults($request)
    {

        if( $request->input('city') != null)
        {
            $dayin = date('Y-m-d', strtotime($request->input('check_in')));
            $dayout = date('Y-m-d', strtotime($request->input('check_out')));

            $result = $this->fR->getSearchResults($request->input('city'));

            if($result)
            {
                foreach($result->rooms as $k=>$room)
                {
                    if((int) $request->input('room_size')>0)
                    {
                        if($room->room_size != $request->input('room_size'))
                        {
                            $result->rooms->forget($k);
                        }

                        foreach($room->reservations as $reservation)
                        {
                            if($dayin >= $reservation->day_in
                            && $dayin <= $reservation->day_out)
                            {
                                $result->rooms->forget($k);
                            }
                            elseif($dayout >= $reservation->day_in
                            && $dayout <= $reservation->day_out)
                            {
                                $result->rooms->forget($k);
                            }
                            elseif( $dayin <= $reservation->day_in
                            && $dayout >= $reservation->day_out)
                            {
                                $result->rooms->forget($k);
                            }
                        }
                    }
                }

                // to do: filter results based on check in and check out etc.

                $request->flash(); // inputs for session for one request

                if(count($result->rooms)> 0)

                return $result;
                else return false; // filtered result

            }

        }
        
        return false;

    }

}







