<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Asteroid;
use Illuminate\Http\Request;

class AsteroidsController extends Controller
{
    private $pageCount = 5;

    public function index(): JsonResponse
    {
        $asteroids = Asteroid::where('is_hazardous', 1)->paginate($this->pageCount)->toArray();
        return response()->json($asteroids);
    }

    public function getTheFasterAsteroid(Request $request): JsonResponse
    {
        $hazardous = (bool)$request->get('hazardous') ?? false;

        $asteroid = Asteroid::where('is_hazardous', $hazardous)->orderBy('speed', 'desc')->first()->toArray();
        return response()->json($asteroid);
    }

    public function getBestYearWithAsteroids(Request $request): JsonResponse
    {
        $hazardous = (bool)$request->get('hazardous') ?? false;

        $yearWithAsteroids = Asteroid::get()->where('is_hazardous', $hazardous)->groupBy('date')->toArray();
        if (!empty($yearWithAsteroids)) {
            $countInYear = $this->getDateWithAsteroids($yearWithAsteroids, 'Y');
        } else {
            $countInYear = [
                'success' => false,
            ];
        }

        return response()->json($countInYear);
    }

    public function getBestMonthWithAsteroids(Request $request): JsonResponse
    {
        $hazardous = $this->isHazardous($request);

        $monthWithAsteroids = Asteroid::get()->where('is_hazardous', $hazardous)->groupBy('date')->toArray();

        if (!empty($monthWithAsteroids)) {
            $countInMonth = $this->getDateWithAsteroids($monthWithAsteroids, 'M');
        } else {
            $countInMonth = [
                'success' => false
            ];
        }

        return response()->json($countInMonth);
    }

    private function isHazardous($request): bool
    {
        return (bool)$request->get('hazardous') ?? false;
    }

    private function getDateWithAsteroids(array $data, string $dateType): array
    {
        $dateWithData = [];
        foreach ($data as $key => $asteroid) {
            $key = date($dateType, strtotime($key));

            if (!key_exists($key, $dateWithData)) {
                $dateWithData[$key] = count($asteroid);
            } else {
                $dateWithData[$key] += count($asteroid);
            }
        }

        $dateKey = '';
        if (count($dateWithData) > 1) {
            $count = 0;
            foreach ($dateWithData as $key => $item) {
                if ($count < $item) {
                    $count = $item;
                    $dateKey = $key;
                }
            }
        } else {
            $dateKey = (string)key($dateWithData);
        }

        $dateWithData = [];
        foreach ($data as $key => $asteroid) {
            $key = date($dateType, strtotime($key));

            if ($key == $dateKey) {
                foreach ($asteroid as $item) {
                    $dateWithData[$dateKey][] = $item;
                }
            }
        }

        return $dateWithData;
    }

}
