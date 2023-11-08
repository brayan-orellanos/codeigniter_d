{extends file="admin/modules/modules.tpl"}

{block name="body_container"}
    <div class="br-pagebody mg-t-3 pd-r-30 pd-t-30 pd-l-30 pd-b-0 bg-light-max">
        <div class="wd-100p mg-t-10">
            <div class="row mg-x-0" id="trace">
                <div class="col-lg-12 p-0 mg-t-30 div-content-trace">
                    <a type="button" href="{$path_trace}" class="btn-m btn_volver">Volver</a>
                    <h6 class="titles">Trazabilidad</h6>
                </div>
                <div class="col-lg-12 mg-t-10">
                    {if $mobile}
                        <div class="timeline block">
                    {else}
                        <div class="timeline block mb-4 pd-l-70-force">
                    {/if}
                        {$data_trace['html']}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}