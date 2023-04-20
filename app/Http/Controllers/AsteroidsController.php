<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Asteroid;

class AsteroidsController extends Controller
{
    private int $pageCount = 5;

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

    public function getBestPeriodWithAsteroids(Request $request, string $period): JsonResponse
    {
        $dateType = $this->checkPeriod($period);

        $hazardous = $this->isHazardous($request);

        $periodWithAsteroids = Asteroid::get()->where('is_hazardous', $hazardous)->groupBy('date')->toArray();

        if (!empty($periodWithAsteroids) && $dateType) {
            $countInYear = $this->getDateWithAsteroids($periodWithAsteroids, $dateType);
        } else {
            $countInYear = [
                'success' => false,
            ];
        }

        return response()->json($countInYear);
    }

    private function isHazardous(Request $request): bool
    {
        return (bool)$request->get('hazardous') ?? false;
    }

    private function checkPeriod(string $period): null|string
    {
        $dateType = null;
        if ($period == 'best-month') {
            $dateType = 'M';
        } elseif ($period == 'best-year') {
            $dateType = 'Y';
        }

        return $dateType;
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
