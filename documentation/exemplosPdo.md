#Exemplos ModelPDO

####Lista todos os registros da tabela

    User::getAll();
        
####Get registro específico

    User::get(1);

####Delete usuário

    $user = new User();
    $user->id = 1;

    if (!$user->delete()) {
        return;
    }

####Update registro

     $user = new User();

     $user->nome = "teste2";
     $user->email = "teste@teste.com";

     if (!$user->save([ id => 1])) {
        return;
     }
     
     obs: save([id=> 1]) é o id do registro que será alterado.