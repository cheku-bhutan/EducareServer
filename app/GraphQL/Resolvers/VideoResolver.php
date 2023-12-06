<?php
namespace App\GraphQL\Resolvers;

use App\Models\Video;
use App\Models\VideoCategory;
use Carbon\Traits\ToStringFormat;

class VideoResolver
{
    public function createVideoCategory($rootValue, array $args)
    {
        $input = $args['input'];

        $videoCategory = new VideoCategory([
            'name' => $input['name'],
            'description' => $input['description'],
        ]);
        
        $videoCategory->save();
        return $videoCategory;
    }

    public function createVideo($rootValue, array $args){
        $input = $args['input'];
        $category = VideoCategory::find($input['category_id']);
        $video = new Video([
            'title' => $input['title'],
            'subtitle' => $input['subtitle'],
            'description' => $input['description'],
            'cover_photo' => $input['cover_photo'],
            'thumbnail' => $input['thumbnail'],
            'status' => $input['status'],
            'release_date' => $input['release_date'],
            'video_url' => $input['video_url'],
        ]);
        $video->category()->associate($category);
        $video->save();
        return $video;
    }

    public function newRelease($rootValue, array $args){
        $count = $args['count'];
        $newReleases = Video::with('category')->where('status', 'Active')->limit($count)->get();
        $newReleaseData =[];
        if($newReleases->count()>0){
            foreach($newReleases as $newRelease){
                array_push($newReleaseData, $newRelease);
            }
            return ['data'=>$newReleaseData];
        }
        return [
            'error' =>[
                'code' => 0,
                'message' => 'No record(s) found'
            ]
        ];
    }
   
}