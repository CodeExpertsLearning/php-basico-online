<?php 

function createFolder()
{
	if(!is_dir(FOLDER)) {
		mkdir(FOLDER);
		mkdir(FOLDER . '/thumbs');
	}
}

function upload($data, $product_id, $pdo)
{
	createFolder();

	for($i = 0; $i < count($data['name']); $i++)
	{
		$ext = strrchr($data['name'][$i], '.');

		$newImageName = sha1($data['name'][$i]) . time() . $ext;

		if(move_uploaded_file($data['tmp_name'][$i], FOLDER. '/thumbs/' . $newImageName)) {
			
			$imageData['image'] = $newImageName;
			$imageData['product_id'] = $product_id;

			saveImages($imageData, $pdo);
		}
	}
}

function removeImage($data, $pdo)
{
	$image = getImage($data['image_id'], $pdo);

	if(!$image) {
		return true;
	}

	if(deleteImage($data, $pdo)) {
		unlink( FOLDER. '/thumbs/' . $image['image']);
	}

	unset($image);

	return true;
}