<?php

namespace Uneca\DisseminationToolkit\Services;

use Uneca\DisseminationToolkit\Http\Resources\ChartDesignerResource;
use Uneca\DisseminationToolkit\Http\Resources\TableDesignerResource;

class VizWizardSession
{
    public static function get(): ChartDesignerResource|TableDesignerResource|null
    {
        $data = session()->get('viz-wizard-resource');

        if ($data instanceof ChartDesignerResource || $data instanceof TableDesignerResource) {
            return $data;
        }

        if (is_array($data) && isset($data['__class'])) {
            $class = $data['__class'];
            unset($data['__class']);
            if ($class === ChartDesignerResource::class || $class === TableDesignerResource::class) {
                $resource = new $class;
                foreach ($data as $key => $value) {
                    $resource->$key = $value;
                }

                return $resource;
            }
        }

        return null;
    }

    public static function put(ChartDesignerResource|TableDesignerResource $resource): void
    {
        $data = get_object_vars($resource);
        $data['__class'] = get_class($resource);
        session()->put('viz-wizard-resource', $data);
    }

    public static function forget(): void
    {
        session()->forget('viz-wizard-resource');
    }
}
