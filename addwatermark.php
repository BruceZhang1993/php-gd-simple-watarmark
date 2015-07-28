	/**
	 * add a watermark to a picture
	 * @param  string  $dis_file       	[picture path]
	 * @param  string  $watermark_file 	[watermark picture path]
	 * @param  mixed $to_file        	[optional: output to a file or false to print out; default: false]
	 * @param  mixed  $pos_x       		[optional: watermark position x; possble options: 'left' 'center' 'right' integer; default: 'right']
	 * @param  mixed  $pos_y          	[optional: watermark position y; possble options: 'top' 'middle' 'bottom' integer; default: 'bottom']
	 * @return void                  	
	 */
	function addwatermark($dis_file, $watermark_file, $to_file=false, $pos_x="right", $pos_y="bottom") {

		//获得底图的文件类型
		$dis_info=getimagesize($dis_file);
		$dis_type=$dis_info[2];
		$dis_width=$dis_info[0];
		$dis_height=$dis_info[1];
		$dis_mime=$dis_info['mime'];

		//根据文件类型导入底图图片资源
		switch ($dis_type) {
			case 1: $dis_img=imagecreatefromgif($dis_file); break;
			case 2: $dis_img=imagecreatefromjpeg($dis_file); break;
			case 3: $dis_img=imagecreatefrompng($dis_file); break;
			default: return; break;
		}

		//获得水印图片文件类型
		$mark_info=getimagesize($watermark_file);
		$mark_width=$mark_info[0];
		$mark_height=$mark_info[1];
		$mark_type=$mark_info[2];

		//根据文件类型导入底图图片资源
		switch ($mark_type) {
			case 1: $mark_img=imagecreatefromgif($watermark_file); break;
			case 2: $mark_img=imagecreatefromjpeg($watermark_file); break;
			case 3: $mark_img=imagecreatefrompng($watermark_file); break;
			default: return; break;
		}

		//处理位置信息
		//pos_x : left center right
		//pos_y : top middle bottom
		switch ($pos_x) {
			case 'left': $pos_x=0; break;
			case 'center': $pos_x=floor(($dis_width-$mark_width)/2); break;
			case 'right': $pos_x=floor($dis_width-$mark_width); break;
			default: $pos_x=floor($pos_x); break;
		}
		switch ($pos_y) {
			case 'top': $pos_y=0; break;
			case 'middle': $pos_y=floor(($dis_height-$mark_height)/2); break;
			case 'bottom': $pos_y=floor($dis_height-$mark_height); break;
			default: $pos_y=floor($pos_y); break;
		}

		//打水印
		imagecopy($dis_img, $mark_img, $pos_x, $pos_y, 0, 0, $mark_width, $mark_height);

		//打印图片或输出到文件
		if($to_file) {
			switch ($dis_type) {
				case 1: imagegif($dis_img, $to_file); break;
				case 2: imagejpeg($dis_img, $to_file); break;
				case 3: imagepng($dis_img, $to_file); break;
				default: return; break;
			}
		}else {
			header("content-type:{$dis_mime}");
			switch ($dis_type) {
				case 1: imagegif($dis_img); break;
				case 2: imagejpeg($dis_img); break;
				case 3: imagepng($dis_img); break;
				default: return; break;
			}
		}

	}
