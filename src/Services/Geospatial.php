<?php

namespace Uneca\DisseminationToolkit\Services;

use Illuminate\Support\Facades\DB;

class Geospatial
{
    public static function getGeoJson(int $level)
    {
        $sql = "
        SELECT
            CASE
                WHEN COUNT(filtered_areas.*) = 0 THEN NULL
                ELSE json_build_object(
                    'type', 'FeatureCollection',
                    'features', json_agg(
                        json_build_object(
                            'type',       'Feature',
                            'geometry',   ST_AsGeoJSON(ST_ForcePolygonCW(filtered_areas.geom))::json,
                            'properties', json_build_object(
                                'code', code,
                                'name', name->>'en',
                                'path', path
                            )
                        )
                    )
                )
            END
        AS feature_collection
        FROM
        (
            SELECT areas.name, areas.code, areas.level, areas.path, ST_SimplifyPreserveTopology(ST_GeomFromWKB(areas.geom), area_hierarchies.simplification_tolerance) AS geom
            FROM areas
            join area_hierarchies on area_hierarchies.index = areas.level
            WHERE areas.level = $level AND areas.geom IS NOT NULL
        ) AS filtered_areas
    ";
        try {
            //dump($sql);
            $result = DB::select($sql);
        } catch (\Exception $exception) {
            logger('Query error in getGeoJson()', ['exception' => $exception->getMessage()]);
            return '';
        }
        return $result[0]?->feature_collection ?? '';
    }
}
