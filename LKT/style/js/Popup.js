// this function is used to generate common popup
		$('#pup_div .pup_dcv').hover(function(){
			var src = $(this).find('img').attr('src').replace('.png','_h.png')
			$(this).find('img').attr('src',src)
		},function(){
			var src = $(this).find('img').attr('src').replace('_h.png','.png')
			$(this).find('img').attr('src',src)
		})
	
	function export_popup1(url,por_class) {
	    var res = `<div class="pup_div" id="pup_div">
				<div class="pup_flex">
					<div class="pup_auto">
						<div class="pup_head"><span>导出数据</span>
							<img src="images/icon/cha.png" onclick="export_close1('${url}','','${por_class}')">
						</div>
						
						<div class="pup_dc">
							<div class="pup_dcv" onclick="export_close1('${url}','This_page','${por_class}')">
								<div>
									<img src="images/iIcon/scby.png" />
									<p>导出本页</p>
								</div>
							</div>
							<div class="pup_dcv" onclick="export_close1('${url}','whole','${por_class}')">
								<div>
									<img src="images/iIcon/dcqb.png" />
									<p>导出全部</p>
								</div>
							</div>
							<div class="pup_dcv" onclick="export_close1('${url}','inquiry','${por_class}')"> 
								<div>
									<img src="images/iIcon/dcss.png" />
									<p>导出查询</p>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>`;
	    $("body",parent.document).append(res);
		$("body",parent.document).find('#pup_div .pup_dcv').hover(function(){
			var src = $(this).find('img').attr('src').replace('.png','_h.png')
			$(this).find('img').attr('src',src)
		},function(){
			var src = $(this).find('img').attr('src').replace('_h.png','.png')
			$(this).find('img').attr('src',src)
		})
	}