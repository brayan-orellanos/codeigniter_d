{extends file="./view.tpl"}
{block name="body_container"}
    <div id="view_traceability_user" class="container-view">
            <a id="navigate_to_list_user_since_traceability_user" href="{$path_trace}" class="btn-nav">Volver</a>
            <p class="title-view">Trazabilidad</p>
            <div class="container-list-traceability">
                {$data_trace['html']}
            </div>
    </div>
{/block}