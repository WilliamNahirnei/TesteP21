import { uploadOrdersFile } from "../../Api/OrderApi.js"
export async function uploadFile() {
    const fileInput = document.getElementById("fileInput");
    if (fileInput.files.length === 0) {
        alert("Por favor, selecione um arquivo.");
        return;
    }

    const file = fileInput.files[0];
    let base64 = null;
    let fileExtension = null;
    if (file) {
        try {
            fileExtension = getFileExtension(file.name);
            base64 = await convertFileToBase64(file);
        } catch (error) {
            console.error("Erro ao converter para Base64:", error);
        }
    }

    if (base64 != null) {

        const contentUpload = {
            fileExtension,
            base64File: base64
        }
        uploadOrdersFile(contentUpload)
    }
}

function getFileExtension(filename) {
    return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
}

function convertFileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        reader.onload = () => {
            const base64String = reader.result.split(',')[1]; // Remove metadados
            resolve(base64String);
        };

        reader.onerror = error => reject(error);

        reader.readAsDataURL(file);
    });
}
