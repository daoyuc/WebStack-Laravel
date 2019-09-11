<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}">
    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')
        
        <div class="col-sm-6">
	        <div id="treecheck-{{$id}}"></div>
          
          <select class="form-control {{$class}}" style="display:none;width: 100%;" name="{{$name}}[]"  id="{{$id}}"  multiple="multiple" data-placeholder="{{ $placeholder }}" {!! $attributes !!} >
          </select>
          {{-- <input type="text" name="{{$name}}[]" /> --}}
	        {{-- <input type="text" name="{{$id}}[]" id="{{$id}}"  {!! $attributes !!} > --}}
	      </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="input-check-node" class="sr-only">筛选:</label>
            <input type="input" class="form-control" id="input-check-node" placeholder="输入菜单名称高亮" value="">
          </div>

          <div class="form-group row">
            <div class="col-sm-3">
            <div class="checkbox">
              <label>
                <input type="checkbox" class="checkbox" id="chk-check-silent" value="false">
                静默模式
              </label>
            </div>
              
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-sm btn-success check-node" id="btn-check-node">{{$settings['checkNode']}}</button>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-sm btn-danger check-node" id="btn-uncheck-node">{{$settings['unCheckNode']}}</button>
            </div>
            <div class="col-sm-2">
            <label></label>
            </div>
            <div class="col-sm-2">
            <button type="button" class="btn btn-sm btn-primary check-node" id="btn-toggle-checked">{{$settings['toggleNode']}}</button>
            </div>
          </div>
          <div class="form-group row">
            
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-2">
              <button type="button" class="btn btn-sm btn-success" id="btn-check-all">{{$settings['checkAll']}}</button>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn btn-sm btn-danger" id="btn-uncheck-all">{{$settings['unCheckAll']}}</button>
            </div>
          </div>
          
        </div>

      <div class="row">
      <label class="col-sm-2 control-label">选中事件</label>
	    <div class="col-sm-6">
          <div id="treecheck-{{$id}}-out" style="height:200px;overflow: scroll;"></div>
        </div>
      </div>
        @include('admin::form.help-block')
    </div>
</div>