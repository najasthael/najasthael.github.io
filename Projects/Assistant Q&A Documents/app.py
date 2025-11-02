import streamlit as stl
import os
from pathlib import Path
from src.document_processing import DocumentProcessing
from src.qa_model import QAModel
from src.text_analyzer import TextAnalyzer
from src.visualizations import Visualizer

stl.set_page_config(page_title="Assistant Q&A de documents", layout="wide")


@stl.cache_data
def models_charging():
    
    
    processor = DocumentProcessing()
    qa = QAModel()
    analyzer = TextAnalyzer()
    visualization = Visualizer()
    
    return processor, qa, analyzer, visualization

stl.title("Assistant Q&A des documents")
stl.markdown("*Posez des questions sur le contenu du document*")
stl.markdown("---")


processor, qa, analyzer, visualization = models_charging()



with stl.sidebar:
    stl.header("Upload un document")
    
    file_types = ['pdf', 'txt', 'docx']

    file = stl.file_uploader("Choisissez un fichier", type=file_types, help="Formats supportés: PDF, TXT, DOCX")
    
    stl.markdown("---")
    stl.markdown("### À propos")



folder_upload = Path("data/uploads")
folder_upload.mkdir(parents=True, exist_ok=True)
    
if file is not None:
    file_path = folder_upload / file.name
    with open(file_path, "wb") as f:
        f.write(file.getbuffer())
    stl.success(f"Fichier '{file.name}' bien chargé.")
else:
    stl.warning("Veuillez uploader un fichier pour commencer.")
