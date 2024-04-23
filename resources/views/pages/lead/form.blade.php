<x-page.form
        title="{{ $lead->exists ? __('Update :name', ['name' => __(config('admix-leads.name'))]) : __('Create :name', ['name' => __(config('admix-leads.name'))]) }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.label for="form.is_active">
                {{ str(__('admix-leads::fields.is_active'))->ucfirst() }}
            </x-form.label>
            <x-form.toggle name="form.is_active"
                           :large="true"
                           :label-on="__('Yes')"
                           :label-off="__('No')"
            />
        </div>
        <div class="col-md-6 mb-3">
        </div>
        <div class="col-md-6 mb-3">
            <x-form.select name="form.source"
                           :label="__('admix-leads::fields.source')"
                           :options="$sourceOptions + config('admix-leads.sources')"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <x-form.input name="form.name" :label="__('admix-leads::fields.name')"/>
        </div>
        <div class="col-md-6 mb-3">
        </div>
        <div class="col-md-6 mb-3">
            <x-form.email name="form.email" :label="__('admix-leads::fields.email')"/>
        </div>
        <div class="col-md-6 mb-3">
            <x-form.input name="form.phone" :label="__('admix-leads::fields.phone')"/>
        </div>
        <div class="col-md-12 mb-3">
            <x-form.textarea name="form.description" :label="__('admix-leads::fields.description')"/>
        </div>
    </div>

    <x-slot:complement>
        @if($lead->exists)
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.id')"
                                  :value="$lead->id"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.created_at')"
                                  :value="$lead->created_at->format(config('admix.timestamp.format'))"/>
            </div>
            <div class="mb-3">
                <x-form.plaintext :label="__('admix::fields.updated_at')"
                                  :value="$lead->updated_at->format(config('admix.timestamp.format'))"/>
            </div>
        @endif
    </x-slot:complement>
</x-page.form>
