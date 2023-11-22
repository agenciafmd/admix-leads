<x-page.form
        headerTitle="{{ $model->id ? __('Update :name', ['name' => __(config('admix-leads.name'))]) : __('Create :name', ['name' => __(config('admix-leads.name'))]) }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.label for="model.is_active">
                {{ Str::of(__('admix-leads::fields.is_active'))->ucfirst() }}
            </x-form.label>
            <x-form.checkbox name="model.is_active"
                             class="form-switch form-switch-lg"
                             :label-on="__('Yes')"
                             :label-off="__('No')"
            />
        </div>
        <div class="col-md-6 mb-3">
        </div>
        <div class="col-md-6 mb-3">
            <x-form.select name="model.source"
                           :label="__('admix-leads::fields.source')"
                           :options="$sourceOptions + config('admix-leads.sources')"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.input name="model.name" :label="__('admix-leads::fields.name')"/>
        </div>
        <div class="col-md-6 mb-3">
        </div>
        <div class="col-md-6 mb-3">
            <x-form.email name="model.email" :label="__('admix-leads::fields.email')"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="model.phone" :label="__('admix-leads::fields.phone')"/>
        </div>
        <div class="col-md-12 mb-3">
            <x-form.textarea name="model.description" :label="__('admix-leads::fields.description')"/>
        </div>
    </div>

    <x-slot:cardComplement>
        @if($model->id)
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.id')"
                                  :value="$model->id"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.created_at')"
                                  :value="$model->created_at->format(config('admix.timestamp.format'))"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.updated_at')"
                                  :value="$model->updated_at->format(config('admix.timestamp.format'))"/>
            </div>
        @endif
    </x-slot:cardComplement>
</x-page.form>
