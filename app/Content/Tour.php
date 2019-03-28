<?php

namespace Ulyssetour\Content;

use Illuminate\Database\Eloquent\Model;
use Ulyssetour\Service\Accommodation;
use Ulyssetour\Service\Food;
use Ulyssetour\Service\Service;
use Ulyssetour\Service\Transport;
use Ulyssetour\Setting\Category;
use Ulyssetour\Setting\City;
use Ulyssetour\Setting\Season;
use Ulyssetour\Service\GuideService;

class Tour extends Model
{
    //
    protected $fillable = [
        'meta_title',
        'meta_description',
        'url',
        'title',
        'category',
        'duration',
        'cost',
        'city',
        'max_qty_tourists',
        'season',
        'schedule',
        'description',
        'program',
        'include_transport',
        'include_guide',
        'include_food',
        'include_service',
        'include_accommodations',
        'ad_service',
        'ad_guide',
        'ad_transport',
        'ad_food',
        'route',
        'conditions',
        'country',
        'image',
        'hot',
        'join_group',
        'lang'
    ];

    protected $appends = [
        'category_title',
        'duration_title',
        'season_title',
        'city_title',

        'include_transport_title',
        'include_guide_title',
        'include_food_title',
        'include_accommodations_title',
        'include_service_title',

        'ad_service_title',
        'ad_guide_title',
        'ad_transport_title',
        'ad_food_title',
    ];

    public function getCityAttribute()
    {
        if (gettype($this->attributes['city']) === "string") {
            return $this->attributes['city'] = json_decode($this->attributes['city']);
        } elseif (gettype($this->attributes['city']) === "array") {
            return $this->attributes['city'];
        } else
            return $this->attributes['city'] = [];
    }

    public function getRouteAttribute()
    {
        if (gettype($this->attributes['route']) === "string") {
            return $this->attributes['route'] = json_decode($this->attributes['route']);
        } elseif (gettype($this->attributes['route']) === "array") {
            return $this->attributes['route'];
        } else
            return $this->attributes['route'] = [];
    }

    public function getProgramAttribute()
    {
        if (gettype($this->attributes['program']) === "string") {
            return $this->attributes['program'] = json_decode($this->attributes['program']);
        } elseif (gettype($this->attributes['program']) === "array") {
            return $this->attributes['program'];
        } else
            return $this->attributes['program'] = [];
    }

    public function getIncludeGuideAttribute()
    {
        if (gettype($this->attributes['include_guide']) === "string") {
            return $this->attributes['include_guide'] = json_decode($this->attributes['include_guide']);
        } elseif (gettype($this->attributes['include_guide']) === "array") {
            return $this->attributes['include_guide'];
        } else
            return $this->attributes['include_guide'] = [];
    }

    public function getIncludeFoodAttribute()
    {
        if (gettype($this->attributes['include_food']) === "string") {
            return $this->attributes['include_food'] = json_decode($this->attributes['include_food']);
        } elseif (gettype($this->attributes['include_food']) === "array") {
            return $this->attributes['include_food'];
        } else
            return $this->attributes['include_food'] = [];
    }

    public function getIncludeServiceAttribute()
    {
        if (gettype($this->attributes['include_service']) === "string") {
            return $this->attributes['include_service'] = json_decode($this->attributes['include_service']);
        } elseif (gettype($this->attributes['include_service']) === "array") {
            return $this->attributes['include_service'];
        } else
            return $this->attributes['include_service'] = [];
    }

    public function getIncludeTransportAttribute()
    {
        if (gettype($this->attributes['include_transport']) === "string") {
            return $this->attributes['include_transport'] = json_decode($this->attributes['include_transport']);
        } elseif (gettype($this->attributes['include_transport']) === "array") {
            return $this->attributes['include_transport'];
        } else
            return $this->attributes['include_transport'] = [];
    }

    public function getIncludeAccommodationsAttribute()
    {
        if (gettype($this->attributes['include_accommodations']) === "string") {
            return $this->attributes['include_accommodations'] = json_decode($this->attributes['include_accommodations']);
        } elseif (gettype($this->attributes['include_accommodations']) === "array") {
            return $this->attributes['include_accommodations'];
        } else
            return $this->attributes['include_accommodations'] = [];
    }

    public function getAdServiceAttribute()
    {
        if (gettype($this->attributes['ad_service']) === "string") {
            return $this->attributes['ad_service'] = json_decode($this->attributes['ad_service']);
        } elseif (gettype($this->attributes['ad_service']) === "array") {
            return $this->attributes['ad_service'];
        } else
            return $this->attributes['ad_service'] = [];
    }

    public function getCategoryTitleAttribute()
    {
        $category = Category::where('id', $this->attributes['category'])->first(['title']);
        return $this->attributes['category_title'] = $category->title;
    }

//    public function getDurationTitleAttribute()
//    {
//        $duration = DB::table('durations')->where('id', $this->attributes['duration'])->first(['title']);
//        return $this->attributes['duration_title'] = $duration->title;
//    }

    public function getSeasonTitleAttribute()
    {
        $season = Season::where('id', $this->attributes['season'])->first(['title']);
        return $season ? $season->title : null;
    }

    public function getCityTitleAttribute()
    {
        if (gettype($this->attributes['city']) === 'string' && $this->attributes['city'] !== 'null')
            $cities = json_decode($this->attributes['city']);
        elseif (gettype($this->attributes['city']) === 'array')
            $cities = $this->attributes['city'];
        else
            $cities = [];

        $cities_title = [];

        foreach ($cities as $city) {
            $cityDB = City::where('id', $city)->first();
            array_push($cities_title, $cityDB->title);
        }

        return $this->attributes['city_title'] = $cities_title;
    }


    public function getIncludeTransportTitleAttribute()
    {
        if (gettype($this->attributes['include_transport']) === 'string' && $this->attributes['include_transport'] !== 'null')
            $values = json_decode($this->attributes['include_transport']);
        elseif (gettype($this->attributes['include_transport']) === 'array')
            $values = $this->attributes['include_transport'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = Transport::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['include_transport_title'] = $objTitle;
    }

    public function getIncludeGuideTitleAttribute()
    {
        if (gettype($this->attributes['include_guide']) === 'string' && $this->attributes['include_guide'] !== 'null')
            $values = json_decode($this->attributes['include_guide']);
        elseif (gettype($this->attributes['include_guide']) === 'array')
            $values = $this->attributes['include_guide'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = GuideService::where('id', 'id')->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['include_guide_title'] = $objTitle;
    }

    public function getIncludeFoodTitleAttribute()
    {
        if (gettype($this->attributes['include_food']) === 'string' && $this->attributes['include_food'] !== 'null')
            $values = json_decode($this->attributes['include_food']);
        elseif (gettype($this->attributes['include_food']) === 'array')
            $values = $this->attributes['include_food'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = Food::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['include_food_title'] = $objTitle;
    }

    public function getIncludeServiceTitleAttribute()
    {
        if (gettype($this->attributes['include_service']) === 'string' && $this->attributes['include_service'] !== 'null')
            $values = json_decode($this->attributes['include_service']);
        elseif (gettype($this->attributes['include_service']) === 'array')
            $values = $this->attributes['include_service'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $service = Service::where('id', $value)->first();
            if ($service)
                $title = $service->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['include_food_title'] = $objTitle;
    }

    public function getIncludeAccommodationsTitleAttribute()
    {
        if (gettype($this->attributes['include_accommodations']) === 'string' && $this->attributes['include_accommodations'] !== 'null')
            $values = json_decode($this->attributes['include_accommodations']);
        elseif (gettype($this->attributes['include_accommodations']) === 'array')
            $values = $this->attributes['include_accommodations'];
        else
            $values = [];


        $objTitle = [];
        foreach ($values as $value) {
            $title = Accommodation::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['include_accommodations_title'] = $objTitle;
    }

    public function getAdServiceTitleAttribute()
    {
        if (gettype($this->attributes['ad_service']) === 'string' && $this->attributes['ad_service'] !== 'null')
            $values = json_decode($this->attributes['ad_service']);
        elseif (gettype($this->attributes['ad_service']) === 'array')
            $values = $this->attributes['ad_service'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = Service::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['ad_service_title'] = $objTitle;
    }

    public function getAdGuideTitleAttribute()
    {
        if (gettype($this->attributes['ad_guide']) === 'string' && $this->attributes['ad_guide'] !== 'null')
            $values = json_decode($this->attributes['ad_guide']);
        elseif (gettype($this->attributes['ad_guide']) === 'array')
            $values = $this->attributes['ad_guide'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = GuideService::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['ad_guide_title'] = $objTitle;
    }

    public function getAdFoodTitleAttribute()
    {
        if (gettype($this->attributes['ad_food']) === 'string' && $this->attributes['ad_food'] !== 'null')
            $values = json_decode($this->attributes['ad_food']);
        elseif (gettype($this->attributes['ad_food']) === 'array')
            $values = $this->attributes['ad_food'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = Food::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['ad_food_title'] = $objTitle;
    }

    public function getAdTransportTitleAttribute()
    {
        if (gettype($this->attributes['ad_transport']) === 'string' && $this->attributes['ad_transport'] !== 'null')
            $values = json_decode($this->attributes['ad_transport']);
        elseif (gettype($this->attributes['ad_transport']) === 'array')
            $values = $this->attributes['ad_transport'];
        else
            $values = [];

        $objTitle = [];
        foreach ($values as $value) {
            $title = Transport::where('id', $value)->first()->title;
            array_push($objTitle, $title);
        }
        return $this->attributes['ad_transport_title'] = $objTitle;
    }

    public function getCountryAttribute()
    {
        return (int)$this->attributes['country'];
    }
}
