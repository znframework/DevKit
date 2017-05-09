@@Form::open():
<div class="row">
    <div class="col-lg-11">
        <h1 class="page-header">
            @@Strings::titleCase(CURRENT_CFUNCTION): <small> {{LANG['overview']}}</small>
        </h1>

    </div>

    <div class="col-lg-1">
        <h1 class="page-header">
            @@Form::class('btn btn-info')->submit('show', LANG['show']):
        </h1>
    </div>
</div>



<div class="row">
    @if( ! empty($files) ) foreach( $files as $file ):
    {[
        $logs = explode('EOL', File::read($path . $file));
    ]}
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-file-text-o fa-fw"></i> @$file:</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>IP #</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $logs as $log ):
                        {[
                            $logEx = explode('|', $log);
                        ]}
                        <tr>
                            <td>@@str_replace('IP/: ',      '', $logEx[0]):</td>
                            <td>@@str_replace('Subject/: ', '', $logEx[1]):</td>
                            <td>@@str_replace('Date/: ',    '', $logEx[2]):/td>
                            <td>@@str_replace('Message/: ', '', $logEx[3]):</td>
                        </tr>
                        @endforeach:
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    @endforeach:
</div>

@@Form::close():