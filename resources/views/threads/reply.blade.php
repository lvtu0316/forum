<reply :attributes="{{ $reply }}" inline-template v-cloak>
<div class="panel panel-default" id="reply-{{ $reply->id }}" >
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                {{ $reply->owner->name }} 回复于
                {{ $reply->created_at->diffForHumans() }}
            </h5>
            <div>
                <favorite :reply="{{ $reply }}"></favorite>
            </div>
        </div>

    </div>

    <div class="panel-body">
        <div v-if="editing">
            <div class="form-group">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <button class="btn btn-xs btn-primary" @click="update">保存</button>
            <button class="btn btn-xs btn-link" @click="editing = false">取消</button>
        </div>
        <div v-else v-text="body">
        </div>
    </div>

    @can('update',$reply)
        <div class="panel-footer level">
            <button class="btn btn-xs mr-1" @click="editing = true">编辑</button>
            <button class="btn btn-xs btn-danger mr-1" @click="destroy">删除</button>
        </div>
    @endcan

</div>
</reply>
