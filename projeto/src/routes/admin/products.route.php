<?php

if($page[2] == 'list') {

	$products = getAll(connection());
	require VIEWS . '/admin/products/index.phtml';
}

if($page[2] == 'delete-image'){
	$data['product_id'] = (int) isset($page[3]) ? $page[3] : null;
	$data['image_id']   = (int) isset($page[4]) ? $page[4] : null;

	if(is_null($data['product_id']) || is_null($data['image_id'])) {
		
		addFlash('error', "Parâmetros de exclusão de imagem inválidos!");

		return header("Location: " . HOME . '/admin/products/edit/' . $data['product_id']);
	}

	removeImage($data, connection());

	$msg = 'Imagem removida com sucesso!';

	addFlash('error', $msg);

	return header("Location: " . HOME . '/admin/products/edit/' . $data['product_id']);
}

if($page[2] == 'edit') {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$data = $_POST;

		$images = $_FILES['images'];


		$data = sanitizerString($data, returnRulesSanitize($data));

		if(!update(connection(), $data)) {
			$msg = 'Erro ao atualizar produto!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/products/edit/' . $data['id']);
		}

		if(isset($images['name'][0])
			&& $images['name'][0] != '') {

			upload($images, $data['id'], connection());	
		}

		$msg = 'Produto atualizado com sucesso!';

		addFlash('success', $msg);

		return header("Location: " . HOME . '/admin/products/edit/' . $data['id']);
	}

	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = (int) isset($page[3]) ? $page[3] : null;
		
		$product = get(connection(), $id);

		if(!$product) {
			$msg = 'Produto não existe!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/products/list');
		}

		$categories = getAllCategories(connection());

		require VIEWS . '/admin/products/edit.phtml';
	} 
}

if($page[2] == 'save') {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$data = $_POST;

		$images = $_FILES['images'];

		$data = sanitizerString($data, returnRulesSanitize($data));

		if(!fieldsRequired($data)) {
			$msg = 'Preencha todos os campos!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/products/save');
		}

		if(getProductBySlug(connection(), $data['slug'])){
			$msg = 'Produto com este slug já existe!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/products/save');
		}

		if(!$productId = create(connection(), $data)) {
			$msg = 'Erro ao inserir produto!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/products/save');
		}

		if(isset($images['name'][0])
			&& $images['name'][0] != '') {

			upload($images, $productId, connection());	
		}
		
		$msg = 'Produto inserido com sucesso!';

		addFlash('success', $msg);

		return header("Location: " . HOME . '/admin/products/list');
	}

	$categories = getAllCategories(connection());

	require VIEWS . '/admin/products/save.phtml';
}

if($page[2] == 'remove') {
 	$id = (int) isset($page[3]) ? $page[3] : null;
	
	if(!delete(connection(), $id)) {
		$msg = 'Erro ao remover produto!';

		addFlash('error', $msg);

		header("Location: " . HOME . '/admin/products/list');
	}

	$msg = 'Produto removido com sucesso!';

	addFlash('success', $msg);


	header("Location: " . HOME . '/admin/products/list');
}
