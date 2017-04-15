<?php 

if($page[2] == 'list') {
	$categories = getAllCategories(connection());

	require VIEWS . '/admin/categories/index.phtml';
}

if($page[2] == 'edit') {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$data = $_POST;

		$data = sanitizerString($data, returnRulesSanitizeCategories($data));

		if(!updateCategory(connection(), $data)) {

			$msg = 'Erro ao atualizar categoria!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/categories/edit/' . $data['id']);
		}

		$msg = 'Categoria atualizado com sucesso!';

		addFlash('success', $msg);

		return header("Location: " . HOME . '/admin/categories/edit/' . $data['id']);
	}

	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		$id = (int) isset($page[3]) ? $page[3] : null;
		
		$category = getCategory(connection(), $id);

		if(!$category) {
			$msg = 'Categoria não existe!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/categories/list');
		}

		require VIEWS . '/admin/categories/edit.phtml';
	} 
}

if($page[2] == 'save') {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$data = $_POST;

		$data = sanitizerString($data, returnRulesSanitizeCategories($data));

		if(!fieldsRequired($data)) {
			$msg = 'Preencha todos os campos!';

			addFlash('error', $msg);

			return header("Location: " . HOME . '/admin/categories/save');
		}

        if(!createCategory(connection(), $data)) {
            $msg = 'Erro ao remover categoria!';

			addFlash('error', $msg);

            header("Location: " . HOME . '/admin/categories/list');
        }

		$msg = 'Categoria inserido com sucesso!';

		addFlash('error', $msg);

		return header("Location: " . HOME . '/admin/categories/list');
	}
	require VIEWS . '/admin/categories/save.phtml';
}

if($page[2] == 'remove') {

	$id = (int) isset($page[3]) ? $page[3] : null;

	if(!deleteCategory(connection(), $id)) {
		$msg = 'Erro ao remover categoria!';

		addFlash('error', $msg);

		header("Location: " . HOME . '/admin/categories/list');
	}

	$msg = 'Categoria removido com sucesso!';

	addFlash('error', $msg);

	header("Location: " . HOME . '/admin/categories/list');
}
