import pygame
import time
import render

class DataTable (object) :
	def __init__ (self, background, font, front_color, back_color, top, left, width, height, rows, cols, gap_y, gap_x) :
		self.background = background
		self.top = int(top)
		self.left = int(left)
		self.width = int(width)
		self.height = int(height)
		self.item_width = int((width -  ((cols-1) * gap_x)) / cols)
		self.item_height = int((height - (rows * gap_y)) / rows)
		self.rows = int(rows)
		self.cols = int(cols)
		self.font = font
		self.gap_y = gap_y
		self.gap_x = gap_x
		self.front_color = front_color
		self.back_color = back_color

	def update(self, data) :
		surface = pygame.Surface((self.width, self.height))
		surface.fill(self.back_color)
		for i in range(len(data)) :
			col = i % self.cols
			row = int(i / self.cols)
			surface.blit(data[i]["image"], data[i]["image"].get_rect(top = (row * self.item_height) + self.gap_y, left = (col * self.item_width)))
			render.render(data[i]["data"], self.font, surface, self.front_color, (col * self.item_width) + data[i]["image"].get_width() + self.gap_x, (row * self.item_height) + self.gap_y, self.item_width - data[i]["image"].get_width() - (2*self.gap_x), self.item_height - self.gap_y) 

		self.background.blit(surface, pygame.Rect(self.left, self.top, self.width, self.height))
