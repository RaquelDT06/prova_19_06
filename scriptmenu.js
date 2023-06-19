const form = document.querySelector('#menuForms')
const nome_pratoInput = document.querySelector('#nome_pratoInput')
const preco_uniInput = document.querySelector('#preco_uniInput')
const descricaoInput = document.querySelector('#descricaoInput')
const tableBody = document.querySelector('#menuTabela tbody')

const URL = "http://localhost:8080/menu.php"

function carregarmenu() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'

        },
        mode: "cors"
    })

        .then(response => response.json())
        .then(menu => {
            tableBody.innerHTML = ''

            menu.forEach(menu => {
                const tr = document.createElement('tr')
                tr.innerHTML = `
        
        <td>${menu.id_item}</td>
        <td>${menu.nome_prato}</td>
        <td>${menu.preco_uni}</td>
        <td>${menu.descricao}</td>
        <td>
        <button data-id="${menu.id_item}" onclick="atualizarmenu(${menu.id_item})">Editar</button>
        <button onclick="excluirmenu(${menu.id_item})">Excluir</button>
        </td>
        `
                tableBody.appendChild(tr)

            })
        })
}

function adicionarmenu(event) {
    event.preventDefault()

    const nome_prato = nome_pratoInput.value
    const preco_uni = preco_uniInput.value
    const descricao = descricaoInput.value
    
    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'

        },
        body: `nome_prato=${encodeURIComponent(nome_prato)}&preco_uni=${encodeURIComponent(preco_uni)}&descricao=${encodeURIComponent(descricao)}`
    
    })

        .then(response => {
            if (response.ok) {
                carregarmenu()
                nome_pratoInput.value = ''
                preco_uniInput.value = ''
                descricaoInput.value = ''
                
            } else {
                console.error('erro ao add item')
                alert('error ao add ')
            }

        })
}

function excluirmenu(id_item) {
    if (confirm('Deseja excluir esse item?')) {
        fetch(`${URL}?id_item=${id_item}`, {
            method: 'DELETE'
        })

            .then(response => {
                if (response.ok) {
                    carregarmenu()
                } else {
                    console.error('Erro ao excluir')
                    alert('Error ao excluir')
                }
            })
    }
}

function atualizarmenu(id_item) {

    const novonome_prato = prompt('Digite o prato')
    const novopreco_uni= prompt('Digite o preço')
    const novodescricao = prompt('Digite a descrição')

    if (novonome_prato && novopreco_uni && novodescricao) {
        fetch(`${URL}?id_item=${id_item}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'

            },
            body: `nome_prato=${encodeURIComponent(novonome_prato)}&preco_uni=${encodeURIComponent(novopreco_uni)}&descricao=${encodeURIComponent(novodescricao)}`
    
        })
            .then(response => {
                if (response.ok){
                    carregarmenu()
                }else{
                    console.error('Erro ao editar')
                    alert('Error ao editar menu')
                }
            })


    }


}


form.addEventListener('submit', adicionarmenu)
carregarmenu()