@php($routeName = str_replace('_', '-', $model->getTable()))
@php($title = $title ?? $model->name)
@php($action = $action ?? 'show')
<a href="{{ route("$routeName.$action", $model->id) }}">{{ $title }}</a>
