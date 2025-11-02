# Assistant Q&A de Documents

Application web pour analyser des documents et répondre à des questions sur leur contenu.

## Fonctionnalités

- Upload de fichiers PDF, TXT et DOCX
- Extraction automatique du texte
- Système de questions-réponses basé sur IA
- Analyse statistique du texte (mots fréquents, entités nommées, etc.)
- Visualisations interactives

## Technologies

- Python 3
- Streamlit
- Transformers (Hugging Face)
- spaCy
- PyPDF2
- Plotly

## Installation

```bash
pip install streamlit transformers spacy PyPDF2 python-docx plotly wordcloud matplotlib

python -m spacy download fr_core_news_md
```

## Utilisation

```bash
streamlit run app.py
```

Puis ouvrir votre navigateur sur `http://localhost:8501`

## Structure du projet

```
├── app.py                      # Application principale
├── src/
│   ├── document_processing.py  # Extraction de texte
│   ├── qa_model.py             # Modèle de Q&A
│   ├── text_analyzer.py        # Analyse de texte
│   └── visualizations.py       # Graphiques
└── data/
    └── uploads/                # Fichiers uploadés
```

## Auteur

Naja Sthael Gonçalves dos Santos Ferreira
