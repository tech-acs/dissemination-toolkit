<?php

namespace Uneca\DisseminationToolkit\Enums;

enum PermissionsEnum: string
{
    // visualization
    case CREATE_VIZ = 'create:viz';
    case EDIT_VIZ = 'edit:viz';
    case PUBLISH_AND_UNPUBLISH_VIZ = 'publish-and-unpublish:viz';
    case DELETE_VIZ = 'delete:viz';

    // story
    case CREATE_STORY = 'create:story';
    case EDIT_STORY = 'edit:story';
    case PUBLISH_AND_UNPUBLISH_STORY = 'publish-and-unpublish:story';
    case DELETE_STORY = 'delete:story';

    // dataset
    case CREATE_DATASET = 'create:dataset';
    case EDIT_DATASET = 'edit:dataset';
    case PUBLISH_AND_UNPUBLISH_DATASET = 'publish-and-unpublish:dataset';
    case IMPORT_DATASET = 'import:dataset';
    case DELETE_DATASET = 'delete:dataset';

    // review
    case APPROVE_REVIEW = 'approve:review';

    public static function grouped(): array
    {
        return [
            'visualization' => [
                self::CREATE_VIZ->value => 'Create',
                self::EDIT_VIZ->value => 'Edit',
                self::PUBLISH_AND_UNPUBLISH_VIZ->value => 'Publish and unpublish',
                self::DELETE_VIZ->value => 'Delete',
            ],
            'story' => [
                self::CREATE_STORY->value => 'Create',
                self::EDIT_STORY->value => 'Edit',
                self::PUBLISH_AND_UNPUBLISH_STORY->value => 'Publish and unpublish',
                self::DELETE_STORY->value => 'Delete',
            ],
            'dataset' => [
                self::CREATE_DATASET->value => 'Create',
                self::EDIT_DATASET->value => 'Edit',
                self::PUBLISH_AND_UNPUBLISH_DATASET->value => 'Publish and unpublish',
                self::IMPORT_DATASET->value => 'Import',
                self::DELETE_DATASET->value => 'Delete',
            ],
            'review' => [
                self::APPROVE_REVIEW->value => 'Approve',
            ]
        ];
    }

    public static function getGroup(string $group): array
    {
        return self::grouped()[$group] ?? [];
    }
}
