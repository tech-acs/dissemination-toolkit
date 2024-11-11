<?php

namespace Uneca\DisseminationToolkit\Http\Resources;

use JsonSerializable;

class ChartDesignerResource implements JsonSerializable
{
    public function __construct(
        public array $dataSources = [],
        public array $data = [],
        public array $layout = [],
        public array $config = [],
        public ?int $vizId = null,
        public string $indicatorTitle = '',
        public array $defaultLayout = [],
        public array $dataParams = [],
        public array $rawData = [],
        public ?string $thumbnail = null,
        public array $options = [],
        //public array $layout = [],
    )
    {}

    public function toArray(): array
    {
        return [
            'dataSources' => (object)$this->dataSources,
            'initialData' => $this->data,
            'initialLayout' => (object)$this->layout,
            'config' => $this->config,
            'vizId' => $this->vizId,
            //'indicatorTitle' => $this->indicatorTitle,
            'defaultLayout' => $this->defaultLayout,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
