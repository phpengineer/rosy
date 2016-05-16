<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
      <form action="<?php echo URL::site('log/list'); ?>" method="get">
        <div class="col-md-3 col-md-offset-9">
          <div class="input-group">
            <input class="form-control" name="keyword" type="text" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="日志id/日志描述/用户名/controller"/>
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
          <th class="w10p">帐号</th>
          <th class="w40p">描述</th>
          <th class="w20p">动作</th>
          <th class="w10p">IP</th>
          <th class="w15p">时间</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if(is_object($logs)) {
            foreach($logs as $log) {
        ?>
        <tr class="gradeX">
          <td class="center"><?php echo $log->getLogId(); ?></td>
          <td><?php echo $log->getAccountName(); ?></td>
          <td><?php echo $log->getMessage(); ?></td>
          <td><?php echo $log->getPortal().'/'.$log->getController().'/'.$log->getAction(); ?></td>
          <td><?php echo $log->getIp(); ?></td>
          <td class="center"><?php echo $log->getCreateTime('Y-m-d H:i:s'); ?></td>
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
