@extends('principal')
@section('contenido')
<template v-if="menu==0">
<h1>Contenido de menu 0 </h1>
</template>

<template v-if="menu==1">
    <categoria></categoria>
</template>

<template v-if="menu==2">
    <h1>Contenido de menu 2 </h1>
</template>
@endsection