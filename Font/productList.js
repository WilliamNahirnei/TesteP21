
function insertProductInList(idProduct, nameProduct, colorProduct, priceProduct, idPrice){
    const productList = document.getElementById("productList")
    const visualProduct = document.createElement("tr")

    visualProduct.id = `listLine${idProduct}${idPrice}`

    let visualProductName = document.createElement("td")
    let visualColorProduct = document.createElement("td")
    let visualPriceProduct = document.createElement("td")
    let visualUpdateButtonContainer = document.createElement("td")
    let visualDeleteButtonContainer = document.createElement("td")

    visualProductName.align="center"
    visualColorProduct.align="center"
    visualPriceProduct.align="center"
    visualUpdateButtonContainer.align="center"
    visualDeleteButtonContainer.align="center"


    let visualUpdateButton = document.createElement("button")
    let visualDeleteButton = document.createElement("button")

    visualUpdateButton.textContent = "Atualizar Dados"
    visualDeleteButton.textContent = "Deletar Registro"

    visualUpdateButton.classList.add ("btn")
    visualUpdateButton.classList.add ("info")

    visualDeleteButton.classList.add ("btn")
    visualDeleteButton.classList.add ("danger")
    visualDeleteButton.addEventListener("click", function (){
        deleteProductPrice(idProduct, idPrice)}
    )

    visualUpdateButton.addEventListener("click", function (){
        constructUpdateForm(idProduct, idPrice)
    })

    visualProductName.appendChild(document.createTextNode(nameProduct))
    visualColorProduct.appendChild(document.createTextNode(colorProduct))
    visualPriceProduct.appendChild(document.createTextNode(`R$ ${priceProduct.toLocaleString('pt-BR')}`))


    visualUpdateButtonContainer.appendChild(visualUpdateButton)
    visualDeleteButtonContainer.appendChild(visualDeleteButton)

    visualProduct.appendChild(visualProductName)
    visualProduct.appendChild(visualColorProduct)
    visualProduct.appendChild(visualPriceProduct)
    visualProduct.appendChild(visualUpdateButtonContainer)
    visualProduct.appendChild(visualDeleteButtonContainer)




    productList.appendChild(visualProduct)
}

function loadProductList(){
    response = getProductWithPriceList()

    response.data.forEach(element => {
        insertProductInList(element.idProduct, element.nameProduct, element.colorProduct, element.price.price, element.price.idPrice)

    });
}

function deleteProductPrice(idProduct, idPrice){
    deleteProductPriceApi(idProduct, idPrice)
    removeElements(`listLine${idProduct}${idPrice}`)
}

function addNewProductPrice(){
    const nameProduct = document.getElementById("inputProductName").value
    const productColor = document.getElementById("inputCollorProduct").value
    const price = document.getElementById("inputPrice").value

    response = insertNewProductPrice(nameProduct, productColor, price)
    responseData = response.data
    insertProductInList(responseData.idProduct, responseData.product.nameProduct, responseData.product.colorProduct, responseData.price, responseData.idPrice)
}

function constructUpdateForm(idProduct, idPrice){

    const response = getProductPriceByIds(idProduct, idPrice)
    const productData = response.data

    productName = productData.nameProduct
    productPrice = productData.price.price

    const containerForm = document.getElementById("containerUpdateForm")

    const updateForm = document.createElement("table")

    updateForm.id = `updateForm${idProduct, idPrice}`

    updateForm.width="100%"
    // updateForm.cellspacing="1"
    // updateForm.cellpadding="1"
    // updateForm.bgcolor="white"

    //headerLine
    const headerLine = document.createElement("tr")
    const nameHeader = document.createElement("th")
    const priceHeader = document.createElement("th")

    nameHeader.textContent = "Nome do Produto"
    priceHeader.textContent = "preço do Produto"

    headerLine.appendChild(nameHeader)
    headerLine.appendChild(priceHeader)
    updateForm.appendChild(headerLine)
    //end headerLine

    //productLine
    const productLine = document.createElement("tr")

    const nameProduct = document.createElement("td")
    const PriceProduct = document.createElement("td")
    const updateContainer = document.createElement("td")
    const cancelContainer = document.createElement("td")

    nameProduct.align="center"
    PriceProduct.align="center"
    updateContainer.align="center"
    cancelContainer.align="center"

    const inputName = document.createElement("input")
    const inputPrice = document.createElement("input")

    inputName.id = `inputName${idProduct, idPrice}`
    inputName.type = "text"
    inputName.value = productName
    nameProduct.appendChild(inputName)
    productLine.appendChild(nameProduct)

    inputPrice.id = `inputPrice${idProduct, idPrice}`
    inputPrice.type = "number"
    inputPrice.value = productPrice
    PriceProduct.appendChild(inputPrice)
    productLine.appendChild(inputPrice)


    const visualUpdateButton = document.createElement("button")
    
    visualUpdateButton.textContent = "Atualizar"

    visualUpdateButton.classList.add ("btn")
    visualUpdateButton.classList.add ("success")
    
    visualUpdateButton.addEventListener("click", function (){
        updateProductPrice(idProduct, idPrice)
    })
    
    updateContainer.appendChild(visualUpdateButton)
    productLine.appendChild(updateContainer)
    

    const visualDeleteButton = document.createElement("button")

    visualDeleteButton.textContent = "Cancelar"
    visualDeleteButton.classList.add ("btn")
    visualDeleteButton.classList.add ("danger")
    visualDeleteButton.addEventListener("click", function (){
        removeElements( `updateForm${idProduct, idPrice}`)
    })

    cancelContainer.appendChild(visualDeleteButton)
    productLine.appendChild(cancelContainer)


    updateForm.appendChild(productLine)
    //end ProductLine

    containerForm.appendChild(updateForm)

}

function updateProductPrice(idProduct, idPrice){
    const nameProduct = document.getElementById(`inputName${idProduct, idPrice}`).value
    const price = document.getElementById(`inputPrice${idProduct, idPrice}`).value

    response = updateProductPriceApi(idProduct, idPrice, nameProduct, price)
    responseData = response.data
    removeElements(`listLine${idProduct}${idPrice}`)
    removeElements( `updateForm${idProduct, idPrice}`)

    insertProductInList(responseData.idProduct, responseData.product.nameProduct, responseData.product.colorProduct, responseData.price, responseData.idPrice)
}



function removeElements(idElement){
    document.getElementById(idElement).remove();
}


// API
function getProductPriceByIds(idProduct, idPrice){
    let request = new XMLHttpRequest();
    request.open("GET", `http://localhost/Avaliacao-PHP-MYSQL/Api/getProductPriceByIds?idProduct=${idProduct}&idPrice=${idPrice}`, false)
    request.send()
    if(request.status!=200){
        alert("erro ao buscar produto e preço especifico")
        return
    }
    response = JSON.parse(request.response)
    return response
}

function getProductWithPriceList(){
    let request = new XMLHttpRequest();
    request.open("GET", "http://localhost/Avaliacao-PHP-MYSQL/Api/getAllProductsWithPrice", false)
    request.send()
    if(request.status!=200){
        alert("erro ao buscar lista de produtos com preços")
        return
    }
    response = JSON.parse(request.response)
    return response
}

function insertNewProductPrice(nameProduct, productColor, price){

    const bodyRequest = JSON.stringify({
        "nameProduct": nameProduct,
        "productColor": productColor,
        "price": price
    })

    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost/Avaliacao-PHP-MYSQL/Api/insertProduct", false)
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest)
    if(request.status!=200){
        alert("erro ao inserir produto e preço")
        return
    }
    response = JSON.parse(request.response)
    return response
}

function updateProductPriceApi(idProduct, idPrice, nameProduct, price){

    const bodyRequest = JSON.stringify({
        "nameProduct": nameProduct,
        "price": price
    })

    let request = new XMLHttpRequest();
    request.open("PUT", `http://localhost/Avaliacao-PHP-MYSQL/Api/updateProductAndPrice?idProduct=${idProduct}&idPrice=${idPrice}`, false)
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest)
    if(request.status!=200){
        alert("erro ao alterar dados")
        return
    }
    response = JSON.parse(request.response)
    return response
}

function deleteProductPriceApi(idProduct, idPrice){
    let request = new XMLHttpRequest();
    request.open("DELETE", `http://localhost/Avaliacao-PHP-MYSQL/Api/DeleteProductPrice?idProduct=${idProduct}&idPrice=${idPrice}`, false)
    request.send()
    if(request.status!=200){
        alert("erro ao deletar")
        return
    }
    response = JSON.parse(request.response)
    return response
}