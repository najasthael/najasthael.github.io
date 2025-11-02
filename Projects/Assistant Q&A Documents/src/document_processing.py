# Auteur: Naja Sthael Gonçalves dos Santos Ferreira
# Module de traitement des documents
# Extrait le texte de fichiers de différents formats

import PyPDF2
from docx import Document


class DocumentProcessing:
    def __init__(self):
        self.type_documents = [".pdf", ".txt", ".docx"]

    def text_identification (self, path_file):
        """
        Identifie le type de fichier d'entrée
        Args:
            path_file: chemin complet du fichier
        Returns:
            appelle les fonctions d'extraction
        """
        if path_file.endswith(".pdf"):
            return self.pdf_extractor(path_file)
        elif path_file.endswith(".docx"):
            return self.doc_extractor(path_file)
        elif path_file.endswith(".txt"):
            return self.txt_extractor(path_file)
        else:
            raise ValueError(f"Le format {path_file[:4]} n'est pas accepté")

    def pdf_extractor (self, path_file):
        
        content = ""
        with open (path_file, "rb") as f:
            pdf_reader = PyPDF2.PdfReader(f)
            for page in pdf_reader.pages:
                content += page.extract_text() + "\n" #ISSO DE extract_text É DESSA BIBLIOTECA?
        return content
    
    def doc_extractor(self, path_file):

        doc = Document(path_file)
        content = ""
        for paragraph in doc.paragraphs:
            content += paragraph.text + "\n"
        return content
    
    def txt_extractor(self, path_file):
        with open(path_file, "r", encoding="utf-8") as f:
            return f.read()