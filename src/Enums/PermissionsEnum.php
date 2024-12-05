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

    // review
    case APPROVE_REVIEW = 'approve:review';

    // topic
    case CREATE_TOPIC = 'create:topic';
    case EDIT_TOPIC = 'edit:topic';
    case DELETE_TOPIC = 'delete:topic';

    // indicator
    case CREATE_INDICATOR = 'create:indicator';
    case EDIT_INDICATOR= 'edit:indicator';
    case DELETE_INDICATOR = 'delete:indicator';

    // dimension
    case CREATE_DIMENSION = 'create:dimension';
    case EDIT_DIMENSION = 'edit:dimension';
    case DELETE_DIMENSION = 'delete:dimension';
    case MANAGE_DIMENSION_VALUES = 'manage-values:dimension';

    // dataset
    case CREATE_DATASET = 'create:dataset';
    case EDIT_DATASET = 'edit:dataset';
    case PUBLISH_AND_UNPUBLISH_DATASET = 'publish-and-unpublish:dataset';
    case IMPORT_DATASET = 'import:dataset';
    case DELETE_DATASET = 'delete:dataset';

    // document
    case CREATE_DOCUMENT = 'create:document';
    case EDIT_DOCUMENT = 'edit:document';
    case DELETE_DOCUMENT = 'delete:document';
    case PUBLISH_AND_UNPUBLISH_DOCUMENT = 'publish-and-unpublish:document';

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
            'review' => [
                self::APPROVE_REVIEW->value => 'Approve',
            ],
            'topic' => [
                self::CREATE_TOPIC->value => 'Create',
                self::EDIT_TOPIC->value => 'Edit',
                self::DELETE_TOPIC->value => 'Delete',
            ],
            'indicator' => [
                self::CREATE_INDICATOR->value => 'Create',
                self::EDIT_INDICATOR->value => 'Edit',
                self::DELETE_INDICATOR->value => 'Delete',
            ],
            'dimension' => [
                self::CREATE_DIMENSION->value => 'Create',
                self::EDIT_DIMENSION->value => 'Edit',
                self::DELETE_DIMENSION->value => 'Delete',
                self::MANAGE_DIMENSION_VALUES->value => 'Manage values',
            ],
            'dataset' => [
                self::CREATE_DATASET->value => 'Create',
                self::EDIT_DATASET->value => 'Edit',
                self::PUBLISH_AND_UNPUBLISH_DATASET->value => 'Publish and unpublish',
                self::IMPORT_DATASET->value => 'Import',
                self::DELETE_DATASET->value => 'Delete',
            ],
            'document' => [
                self::CREATE_DOCUMENT->value => 'Create',
                self::EDIT_DOCUMENT->value => 'Edit',
                self::DELETE_DOCUMENT->value => 'Delete',
                self::PUBLISH_AND_UNPUBLISH_DOCUMENT->value => 'Publish and unpublish',
            ],
        ];
    }

    public static function getGroup(string $group): array
    {
        return self::grouped()[$group] ?? [];
    }
}
