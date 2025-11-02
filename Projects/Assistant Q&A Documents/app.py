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




    with stl.spinner("...Extraction du texte..."):
        text = processor.text_identification(str(file_path))

    

    if not text or len(text) < 10:
        stl.warning("Le document n'a pas de contenu ou est illisible")
        stl.stop()
    
    col1, col2, col3 = stl.tabs(["Questions/Réponses", "Résultat de l'analyse", "Texte original"])

    with col1:
        stl.subheader("Question sur le document: ")
        
        question = stl.text_input(
            "Posez la question: ",
            placeholder="Ex: Quel est le thème de ce document?",
            key="question_input"
        )
        
        if stl.button("Lancez", type="primary"):
            if question:
                with stl.spinner("Le système est en train de chercher la réponse."):
                    result = qa_model.answer_question(question, text)
                    
                    if result['score'] > 0:
                        stl.markdown("###Réponse trouvée:")
                        stl.success(result['answer'])
                        
                        reliability = result['score'] * 100
                        stl.metric("Confiance", f"{reliability:.1f}%")
                        
                        if stl.checkbox("Voir le contexte dans le document"):
                            debut, fin = result['position']
                            context = qa_model.answer_context(text, start, end)
                            
                            stl.markdown("**Extrait du document:**")
                            stl.info(context)
                    else:
                        stl.warning("Pas de réponse trouvée pour cette question")
            else:
                stl.warning("Entrez une question d'abord!")

    with col2:
        stl.subheader("Analyse du texte")
        
        with stl.spinner("En train d'analyser le document"):
            analisis = analyzer.analyze_text(text)
        
        stl.markdown("###Statistiques générales")
        metric_col1, metric_col2, metric_col3 = stl.columns(3)
        
        with metric_col1:
            stl.metric("Total caractères", f"{analisis['nb_char']:,}")
        
        with metric_col2:
            stl.metric("Total mots", f"{analisis['nb_mots']:,}")
        
        with metric_col3:
            stl.metric("Total phrases", f"{analisis['nb_sents']:,}")
        
        stl.markdown("---")
        
        if analisis['words_frequency'] and len(analisis['words_frequency'][0]) > 0:
            stl.markdown("###Les mots les plus fréquents")
            
            freq_chart = visualization.frequencies_graphs(
                analisis['words_frequency'][0],
                titre="15 mots les plus fréquents"
            )
            stl.plotly_chart(freq_chart, use_container_width=True)
            
            if stl.checkbox("Nuage de mots: "):
                wordcloud_pic = visualization.make_wordcloud(analisis['words_frequency'][0])
                stl.image(wordcloud_pic, use_column_width=True)
        
        stl.markdown("---")
        
        if analisis['entities'] and len(analisis['entities'][0]) > 0:
            stl.markdown("###Entités nommées détectées")
            
            entities_chart = visualization.entities_graphs(analisis['entities'][0])
            if entities_chart:
                stl.plotly_chart(entities_chart, use_container_width=True)
            
            if stl.checkbox("::Liste complète des entités::"):
                entities_list = analisis['entities'][0]
                stl.dataframe(entities_list, use_container_width=True)
        else:
            stl.info("Aucune entité détectée.")
        
        stl.markdown("---")
        
        if analisis['pos_tags']:
            stl.markdown("###Les catégories grammaticales du document: ")
            
            pos_chart = visualization.pos_graphs(analisis['pos_tags'])
            stl.plotly_chart(pos_chart, use_container_width=True)
        
        stl.markdown("---")
        stl.markdown("###::Bigrammes les plus fréquents::")
        
        bigrams = analyzer.get_bigrams(text, n=2, top_n=10)
        
        if bigrams:
            bigram_df = stl.dataframe(bigrams, column_config={0: "Bigramme", 1: "Fréquence"}, hide_index=True, use_container_width=True)
    
    with col3:
        stl.subheader("Texte original du document: ")
        
        options = ["Voir le texte complet", "Voir les premiers 1000 caractères", "Voir les derniers 1000 caractères"]
        display_option = stl.radio("Options d'affichage: ",options,horizontal=True)
        
        if display_option == options[0]:
            stl.text_area("Contenu", text, height=600)
        elif display_option == options[1]:
            preview = text[:1000] + "..." if len(text) > 1000 else text
            stl.text_area("Aperçu (début)", preview, height=400)
            
        else:
            preview = "..." + text[-1000:] if len(text) > 1000 else text
            stl.text_area("Aperçu (fin)", preview, height=400)
            
        
        stl.download_button(
            label="Télécharger le texte extrait",
            data=text,
            file_name=f"{file.name}_extracted.txt",
            mime="text/plain"
        )

else:
    stl.warning("Veuillez uploader un fichier pour commencer.")



