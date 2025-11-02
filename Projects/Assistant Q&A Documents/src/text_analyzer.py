import spacy
from collections import Counter
import re

class TextAnalyzer:
    def __init__(self, model_name="fr_core_news_md"):
        self.text_analisis = spacy.load(model_name)
    
    def analyze_text(self, text):
        doc = self.text_analisis(text)


        nb_char = len(text)
        
        nb_mots = 0
        for token in doc:
            if not token.is_space:
                nb_mots += 1

        nb_sents = 0
        for sentence in doc.sents:
            nb_sents += 1


        entities = self.entities_extraction(doc)
        words_frequency = self.get_words_frequency (doc, top_n=20)
        pos_tags = self.get_pos_distribution(doc)


        analisis = {
            "nb_char": nb_char,
            "nb_mots": nb_mots,
            "nb_sents": nb_sents,
            "entities": entities,
            "words_frequency": words_frequency,
            "pos_tags": pos_tags
        }

        return analisis
    
    def entities_extraction (self, doc):
        entities = []
        for ent in doc.ents:
            entities.append({
                "text": ent.text,
                "label": ent.label_,
                "start": ent.start_char,
                "end": ent.end_char
            })
        return entities
    

    def get_words_frequency (self, doc, top_n=20):
        words =[]
        for token in doc:
            if not token.is_stop and not token.is_punct and not token.is_space and len(token.text) > 2:
                words.append(token.text.lower())
        word_freq = Counter(words)
    
        return (word_freq.most_common(top_n),)


    
    def get_pos_distribution(self, doc):
        pos_tags = []
        for token in doc:
            if not token.is_space:
                pos_tags.append(token.pos_)
        pos_qtt = Counter(pos_tags)
        return dict(pos_qtt)
        


    def get_bigrams(self, text, n=2, top_n=10):
        words = re.findall(r'\b\w+\b', text.lower())

        bigrams = []
        for i in range(len(words) - n + 1):
            bigram = words[i:i+n]
            bigrams.append(' '.join(bigram))

        bigram_freq = Counter(bigrams)
        return bigram_freq.most_common(top_n)

    
