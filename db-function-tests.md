// ----------------- TEST CREATE --------------------------

        // $guitar = new Guitar();
        // $firstGuitarType = $guitarTypeService->get(1);
        // $firstOrder = $orderService->get(1);
        // $guitar
        //     ->setGuitarType($firstGuitarType)
        //     ->setModel("createTestModel")
        //     ->setDeleted(false)
        //     ->setColor("createText-color")
        //     ->setPrice("5666,00")
        //     ->setUsed(0)
        //     ->setGuitarOrder($firstOrder)
        //     ;
        // $guitarService->store($guitar);


        // $guitarType = new GuitarType();
        // $guitarType
        //     ->setVersion("test-create-version")
        //     ->setBrand("test-create-brand")
        //     ->setBody("test-create-body")
        //     ->setPickup("test-create-pickup")
        //     ->setType("rest-create-type")
        //     ->setSaddlewidth(999)
        //     ->setDeleted(false)
        //     ->setNeck("test-create-neck")
        //     ->setSize("test-create-size")
        //     ->setFretboard('test-create-Fretboard')
        //     ->setScale(888)
        //     ;
        // $guitarTypeService->store($guitarType);

        // $image = new Image();
        // $image 
        //     ->setName("test-create-name");
        // $imageService->store($image);

        // $imageGuitar = new ImageGuitar();
        // $firstImage = $imageService->get(1);
        // $firstGuitar = $guitarService->get(1);
        // $imageGuitar
        //     ->setImage($firstImage)
        //     ->setGuitar($firstGuitar)
        //     ;
        // $imageGuitarService->store($imageGuitar);
        
        // $order = new Order();
        // $dateOne = new \DateTimeImmutable();
        // $dateTwo = new \DateTimeImmutable();
        // $user = $userService->get(1);
        // $order
        //     ->setDate($dateOne)
        //     ->setPayDate($dateTwo)
        //     ->setUser($user)
        //     ;
        // $orderService->store($order);

        // $newUser = new User();
        // $email = "test@email.de";
        // $Roles = ["Role_User"];
        // $password = "useruser";
        // $street = "TestCreatestraße";
        // $housenumber = 999;
        // $zipcode = 888;
        // $city = "test-city";
        // $firstname = "test-create";
        // $lastname = "test-create-nachname";
        // $deleted = 0;
        // $newUser
        //     ->setEmail($email)
        //     ->setRoles($Roles)
        //     ->setPassword($password)
        //     ->setStreet($street)
        //     ->setHouseNumber($housenumber)
        //     ->setZipcode($zipcode)
        //     ->setCity($city)
        //     ->setFirstname($firstname)
        //     ->setLastname($lastname)
        //     ->setDeleted($deleted)
        //     ;
        // $userService->store($newUser);


// ----------------- TEST READ --------------------------

        // $guitar = $guitarService->get(1);
        // var_dump($guitar->getModel());
        // echo "<br><br>";

        // $user = $userService->get(1);
        // var_dump($user->getFirstname());
        // echo "<br><br>";

        // $guitarTypeService = $guitarTypeService->get(1);
        // var_dump($guitarTypeService->getType());
        // echo "<br><br>";

        // $imageService = $imageService->get(1);
        // var_dump($imageService->getName());
        // echo "<br><br>";

        // $orderService = $orderService->get(1);
        // var_dump($orderService->getDate());
        // echo "<br><br>";


        // $imageGuitarService = $imageGuitarService->get(5);
        // var_dump($imageGuitarService->getGuitar()->getModel());
        // echo "<br><br>";


// ----------------- TEST UPDATE --------------------------

        // $guitar = $guitarService->get(1);
        // $guitar->setModel("test-modell");
        // $guitarService->store($guitar);

        // $user = $userService->get(1);
        // $user->setFirstname("test-Flynn");
        // $userService->store($user);

        // $guitarType = $guitarTypeService->get(1);
        // $guitarType->setType("test-type");
        // $guitarService->store($guitarType);

        // $image = $imageService->get(1);
        // $image->setName("test-name");
        // $imageService->store($image);

        // $order = $orderService->get(1);
        // $newDate = new \DateTimeImmutable();
        // $order->setDate($newDate);
        // $orderService->store($order);



// ----------------- TEST DELETE --------------------------

        // $guitar = $guitarService->get(17);
        // $guitarService->remove($guitar);

        // $image = $imageService->get(8);
        // $imageService->remove($image);

        // $imageGuitar = $imageGuitarService->get(16);
        // $imageGuitarService->remove($imageGuitar);

        

        // ~~~~~~~~~~~~~~~~~~~~ KLAPPT SO LEIDER NICHT (wegen Cascaden): ~~~~~~~~~~~
        // $guitarType = $guitarTypeService->get(3);
        // $guitarTypeService->remove($guitarType);

        // order removement Function

        // user removement Function