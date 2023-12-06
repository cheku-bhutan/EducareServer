<?php
namespace App\GraphQL\Resolvers;

use App\Models\FeaturedAd;

class FeaturedAdResolver
{
    public function createFeaturedAd($rootValue, array $args)
    {
        $input = $args['input'];

        $featuredAd = new FeaturedAd([
            'title' => $input['title'],
            'sub_title' => $input['sub_title']??null,
            'description' => $input['description']??null,
            'status' => $input['status'],
            'cover_photo' => $input['cover_photo'],
            'type' => $input['type'],
        ]);
        
        $featuredAd->save();

        return $featuredAd;
    }

    public function deleteFeaturedAd($rootValue, array $args)
    {
        $id = $args['id'];

        $featuredAd = FeaturedAd::find($id);
        
        $featuredAd->softDelete($id);

        return $featuredAd;
    }

    public function featuredAds($rootValue, array $args)
    {
        $count = $args['count'];

        $featuredAds = FeaturedAd::where('status', 'Active')->limit($count)->get();
        $featuredAdsData =[];
        if($featuredAds->count()>0){
            foreach($featuredAds as $featuredAd){
                array_push($featuredAdsData, $featuredAd);
            }
            return ['data'=>$featuredAdsData];
        }
        return [
            'error' =>[
                'code' => 0,
                'message' => 'No record(s) found'
            ]
        ];
    }
    
}