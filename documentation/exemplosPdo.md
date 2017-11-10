#Exemplos ModelPDO

####Lista todos os registros da tabela
        User::getAll();
        
####Get registro específico
    User::get(1);

####Delete usuário
    $user = User::get(1);

    if (!$user->delete()) {
        return;
    }

####Update registro

     $user = new User();
     $user->id = 2;
     $user->nome = "teste2";
     $user->email = "teste@teste.com";

     if (!$user->save()) {
        return;
     }