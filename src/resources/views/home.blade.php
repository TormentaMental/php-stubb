@extends('app')

@section('content')

<div class="main-column col-md-8" ng-controller="HomeController">

    <div class="new-copy clearfix">
        <form ng-submit="createShard()">
            <div class="panel panel-default">
                <div class="panel-body">
                    <textarea class="form-control margin-bottom-md" name="copy" 
                        placeholder="Write something and hash it..." ng-model="copy"></textarea>
                </div>
            </div> 

            <button type="submit" class="btn btn-primary pull-right drops-shadow">Submit</button>
        </form>
    </div>

    <div class="list">
        <div class="text-left">

            <div ng-if="shards">
                <div ng-repeat="shard in shards">    
                    <div class="panel panel-default">
                        <div class="panel-body">{{ shard.text}}</div>
                    </div>
                </div>
            </div>

            <div ng-if="!shards.length">
                <div>{{ translations.no_results }}</div>
            </div>
        </div>
        <ul class="pagination pull-right">
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
        </ul>
    </div>
</div>
<div class="side-column col-md-4">

    <div class="panel panel-default tag-cloud">
        <div class="panel-body">
            <ul class="list-unstyled list-inline">
                <li><button class="btn btn-xs btn-info">filter Label</button></li>
                <li><button class="btn btn-xs btn-info">Info Label</button></li>
                <li><button class="btn btn-xs btn-info">Info Label</button></li>
                <li><button class="btn btn-xs btn-info">Info Label</button></li>
                <li><button class="btn btn-xs btn-info">Info Label</button></li>
            </ul>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
                <input type="text" class="form-control" name="filter" placeholder="Filter" aria-describedby="filter"/>
            </div>
        </div>
    </div>

</div>

@stop