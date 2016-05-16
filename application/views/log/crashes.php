<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <form action="<?php echo URL::site('log/crashes'); ?>" method="get">
        <div class="col-md-3 col-md-offset-9">
          <div class="input-group">
            <input class="form-control" name="keyword" type="text" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="文件名/消息/主机名/IP"/>
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
            </span>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th class="w5p">ID</th>
          <th class="w10p">等级</th>
          <th class="w50p">文件</th>
          <th class="w20p">主机</th>
          <th class="w15p">时间</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if(is_object($crashes)) {
            foreach($crashes as $crash) {
        ?>
        <tr class="gradeX">
          <td class="center"><?php echo $crash->getLogCrashId(); ?></td>
          <td><?php echo $crash->getLevel(); ?></td>
          <td>
            <a data-toggle="collapse" data-target="#<?php echo $crash->getLogCrashId();?>"><?php echo $crash->getFile(); ?></a>
            <div id="<?php echo $crash->getLogCrashId();?>" class="collapse"><strong><?php echo $crash->getMessage(); ?></strong></div>
          </td>
          <td>
            <a data-toggle="collapse" data-target="#host_<?php echo $crash->getLogCrashId();?>"><?php echo $crash->getHostname(); ?></a>
            <div id="host_<?php echo $crash->getLogCrashId();?>" class="collapse"><strong><?php echo $crash->getIp();?>
          </td>
          <td class="center"><?php echo $crash->getCreateTime('Y-m-d H:i:s'); ?></td>
        </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="panel-footer">
    <div class="row">
      <div class="col-md-12 left">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</div>
