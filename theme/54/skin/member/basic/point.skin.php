<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="point" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>

    <div class="new_win_con2">
        <ul class="point_all">
        	<li class="full_li">
        		보유포인트
        		<span><?php echo number_format($member['mb_point']); ?></span>
        	</li>
        	<li>지급포인트<span>+ 10,500<?php // echo $sum_point1; ?></span></li>
        	<li>사용포인트 <span>- 20,123<?php // echo $sum_point2; ?></span></li>
		</ul>
        <ul class="point_list">
        	
        	<!--****** 예시(모바일도) ******-->
        	
        	<li><!-- 지급 -->
        		<div class="point_top">
					<span class="point_tit">자유게시판</span>
                    <span class="point_num">+1</span>  
				</div>
				<span class="point_date1"><i class="fa fa-clock-o" aria-hidden="true"></i> 2018-11-15 15:11:24</span>        		
        	</li>
        	
        	<li class="point_use"><!-- 차감 -->
        		<div class="point_top">
					<span class="point_tit">자유게시판</span>
                    <span class="point_num">+1</span>  
				</div>
				<span class="point_date1"><i class="fa fa-clock-o" aria-hidden="true"></i> 2018-11-15 15:11:24</span>       		
        	</li>
        	
        	<!--****** 예시 ******-->
        	
        	
            <?php
            $sum_point1 = $sum_point2 = $sum_point3 = 0;

            $sql = " select *
                        {$sql_common}
                        {$sql_order}
                        limit {$from_record}, {$rows} ";
            $result = sql_query($sql);
            for ($i=0; $row=sql_fetch_array($result); $i++) {
                $point1 = $point2 = 0;
                if ($row['po_point'] > 0) {
                    $point1 = '+' .number_format($row['po_point']);
                    $sum_point1 += $row['po_point'];
                } else {
                    $point2 = number_format($row['po_point']);
                    $sum_point2 += $row['po_point'];
                }

                $po_content = $row['po_content'];

                $expr = '';
                if($row['po_expired'] == 1)
                    $expr = ' txt_expired';
            ?>
            <li>
                <div class="point_top">
                    <span class="point_tit"><?php echo $po_content; ?></span>
                    <span class="point_num"><?php if ($point1) echo $point1; else echo $point2; ?></span>
                </div>
                <span class="point_date1"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['po_datetime']; ?></span>
                <span class="point_date<?php echo $expr; ?>">
                    <?php if ($row['po_expired'] == 1) { ?>
                    만료 <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                    <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                </span>
            </li>
            <?php
            }

            if ($i == 0)
                echo '<li class="empty_li">자료가 없습니다.</li>';
            else {
                if ($sum_point1 > 0)
                    $sum_point1 = "+" . number_format($sum_point1);
                $sum_point2 = number_format($sum_point2);
            }
            ?>
        </ul>
    </div>

    <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

    <button type="button" onclick="javascript:window.close();" class="btn_close">창닫기</button>
</div>